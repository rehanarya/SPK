<?php

namespace App\Http\Requests;

use App\Models\Pengajuan;
use App\Services\AnalisisPembiayaanService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

/**
 * Validasi formulir "Analisis Pembiayaan" (create & edit pengajuan).
 *
 * Dua mode isian:
 *  - 'analisis'  : formulir manual lengkap — C1 & C2 dihitung server-side
 *                  dari komponen (mode standar untuk pengajuan baru).
 *  - 'langsung'  : fallback isian kriteria langsung untuk rekord historis
 *                  (N01–N20) yang tidak memiliki rincian komponen.
 */
class PengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // otorisasi peran ditangani middleware role:petugas,admin
    }

    public function modeAnalisis(): bool
    {
        return $this->input('mode_input', 'analisis') === 'analisis';
    }

    public function rules(): array
    {
        // Aturan lama untuk kriteria & identitas dipertahankan (tenor maks. 48 bulan)
        $rules = [
            'id_nasabah'        => ['required', 'exists:nasabah,id_nasabah'],
            'tanggal_pengajuan' => ['required', 'date'],
            'C3_nilai_agunan'   => ['required', 'integer', 'in:1,2,3,4'],
            'C4_besar_pembiayaan' => ['required', 'numeric', 'min:1'],
            'C5_jangka_waktu'   => ['required', 'integer', 'min:1', 'max:48'],
            // Realisasi & tanda tangan Manager (seksi bawah form edit) — opsional
            // untuk semua status; berlaku juga pada mode fallback data historis
            'tanggal_realisasi' => ['nullable', 'date'],
            'nama_manager'      => ['nullable', 'string', 'max:100'],
            'ttd_manager'       => ['nullable', 'string', 'regex:/^data:image\/png;base64,/'],
        ];

        if ($this->modeAnalisis()) {
            // Komponen formulir manual — numerik ≥ 0.
            // Bagi hasil TIDAK divalidasi/diambil dari klien: selalu dihitung
            // server-side 2% × Besarnya Pembiayaan (AnalisisPembiayaanService).
            $komponen = [
                'pendapatan_pasangan', 'pendapatan_lainnya',
                'kebutuhan_rumah_tangga', 'biaya_pendidikan', 'biaya_lainnya',
                'simpanan',
            ];
            foreach ($komponen as $field) {
                $rules[$field] = ['required', 'numeric', 'min:0'];
            }

            // Nasabah pegawai: penjualan_usaha diisi gaji bulanan (wajib > 0),
            // HPP dan biaya usaha boleh kosong (diperlakukan 0 saat menghitung)
            $rules['penjualan_usaha']  = ['required', 'numeric', 'min:1'];
            $rules['harga_pokok_jual'] = ['nullable', 'numeric', 'min:0'];
            $rules['biaya_usaha']      = ['nullable', 'numeric', 'min:0'];

            $rules['rasio_angsuran']    = ['required', 'numeric', 'min:1', 'max:100'];
            $rules['jenis_akad']        = ['required', Rule::in(Pengajuan::AKAD_LIST)];
            $rules['sumber_penghasilan'] = ['nullable', Rule::in(['usaha', 'gaji'])];

            // Tanda tangan digital opsional — dataURL PNG dari x-signature-pad
            $rules['ttd_anggota'] = ['nullable', 'string', 'regex:/^data:image\/png;base64,/'];
            $rules['ttd_petugas'] = ['nullable', 'string', 'regex:/^data:image\/png;base64,/'];
        } else {
            // Fallback historis: kriteria C1 & C2 diisi langsung seperti semula
            $rules['C1_laba_usaha']        = ['required', 'numeric', 'min:1'];
            $rules['C2_pendapatan_bersih'] = ['required', 'numeric', 'min:1'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'penjualan_usaha'        => 'Penjualan Usaha',
            'harga_pokok_jual'       => 'Harga Pokok Jual',
            'biaya_usaha'            => 'Biaya Usaha',
            'pendapatan_pasangan'    => 'Pendapatan dari Istri/Suami',
            'pendapatan_lainnya'     => 'Pendapatan Lainnya',
            'kebutuhan_rumah_tangga' => 'Kebutuhan Rumah Tangga',
            'biaya_pendidikan'       => 'Biaya Pendidikan',
            'biaya_lainnya'          => 'Biaya Lainnya',
            'rasio_angsuran'         => 'Rasio Angsuran',
            'simpanan'               => 'Simpanan',
            'sumber_penghasilan'     => 'Sumber Penghasilan Utama',
            'ttd_anggota'            => 'Tanda Tangan Anggota',
            'ttd_petugas'            => 'Tanda Tangan Petugas',
            'nama_manager'           => 'Nama Manager',
            'ttd_manager'            => 'Tanda Tangan Manager',
            'jenis_akad'             => 'Jenis Akad',
            'tanggal_realisasi'      => 'Tanggal Realisasi',
            'C4_besar_pembiayaan'    => 'Besarnya Pembiayaan',
            'C5_jangka_waktu'        => 'Jangka Waktu',
        ];
    }

    /**
     * Validasi bisnis: laba usaha dan pendapatan bersih hasil hitung harus
     * positif — domain WP mensyaratkan seluruh nilai kriteria > 0.
     */
    public function after(): array
    {
        return [
            // Tanggal realisasi (bila diisi) tidak boleh mendahului tanggal pengajuan
            function (Validator $validator) {
                if ($this->filled('tanggal_realisasi') && $this->filled('tanggal_pengajuan')
                    && strtotime($this->input('tanggal_realisasi')) < strtotime($this->input('tanggal_pengajuan'))) {
                    $validator->errors()->add(
                        'tanggal_realisasi',
                        'Tanggal realisasi tidak boleh sebelum tanggal pengajuan.'
                    );
                }
            },
            function (Validator $validator) {
                if (! $this->modeAnalisis() || $validator->errors()->isNotEmpty()) {
                    return;
                }

                $hasil = app(AnalisisPembiayaanService::class)->hitung($this->validated());

                if ($hasil['laba_usaha'] <= 0) {
                    $validator->errors()->add(
                        'biaya_usaha',
                        'Laba Usaha hasil hitung (Penjualan − Harga Pokok Jual − Biaya Usaha) harus lebih dari Rp 0. Periksa kembali angka Seksi 1.'
                    );
                }

                if ($hasil['pendapatan_bersih'] <= 0) {
                    $validator->errors()->add(
                        'biaya_lainnya',
                        'Pendapatan Bersih hasil hitung (Jumlah Pendapatan − Jumlah Pengeluaran) harus lebih dari Rp 0. Pengajuan tidak dapat dinilai bila pendapatan bersih negatif atau nol.'
                    );
                }
            },
        ];
    }
}
