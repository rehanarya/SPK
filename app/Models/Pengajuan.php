<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';
    protected $primaryKey = 'id_pengajuan';
    public $timestamps = false;

    /** Pemetaan skala ordinal C3 → label agunan formulir manual */
    public const AGUNAN_LABELS = [
        1 => 'Tanpa Agunan',
        2 => 'BPKB Sepeda Motor',
        3 => 'BPKB Mobil',
        4 => 'Sertifikat Tanah / Bangunan',
    ];

    /** Jenis akad yang tersedia pada blok persetujuan formulir manual */
    public const AKAD_LIST = ['Murabahah', 'Mudharabah', 'Musyarakah', 'Ijarah', 'Qardh'];

    protected $fillable = [
        'id_nasabah',
        'id_periode',
        'C1_laba_usaha',
        'C2_pendapatan_bersih',
        'C3_nilai_agunan',
        'C4_besar_pembiayaan',
        'C5_jangka_waktu',
        'tanggal_pengajuan',
        // Komponen formulir "Analisis Pembiayaan" (nullable untuk data historis)
        'penjualan_usaha',
        'harga_pokok_jual',
        'biaya_usaha',
        'pendapatan_pasangan',
        'pendapatan_lainnya',
        'kebutuhan_rumah_tangga',
        'biaya_pendidikan',
        'biaya_lainnya',
        'rasio_angsuran',
        'plafon_pembiayaan',
        'angsuran_pokok',
        'bagi_hasil',
        'simpanan',
        'jumlah_angsuran',
        'jenis_akad',
        'tanggal_realisasi',
        'sumber_penghasilan',
        'ttd_anggota',
        'ttd_petugas',
    ];

    protected function casts(): array
    {
        return [
            'C1_laba_usaha'          => 'float',
            'C2_pendapatan_bersih'   => 'float',
            'C3_nilai_agunan'        => 'integer',
            'C4_besar_pembiayaan'    => 'float',
            'C5_jangka_waktu'        => 'integer',
            'tanggal_pengajuan'      => 'date',
            'penjualan_usaha'        => 'float',
            'harga_pokok_jual'       => 'float',
            'biaya_usaha'            => 'float',
            'pendapatan_pasangan'    => 'float',
            'pendapatan_lainnya'     => 'float',
            'kebutuhan_rumah_tangga' => 'float',
            'biaya_pendidikan'       => 'float',
            'biaya_lainnya'          => 'float',
            'rasio_angsuran'         => 'float',
            'plafon_pembiayaan'      => 'float',
            'angsuran_pokok'         => 'float',
            'bagi_hasil'             => 'float',
            'simpanan'               => 'float',
            'jumlah_angsuran'        => 'float',
            'jenis_akad'             => 'string',
            'tanggal_realisasi'      => 'date',
            'sumber_penghasilan'     => 'string',
        ];
    }

    /**
     * Rekord historis (N01–N20) tidak memiliki rincian komponen analisis —
     * dipakai view untuk fallback mode isian kriteria langsung.
     */
    public function punyaRincianAnalisis(): bool
    {
        return $this->penjualan_usaha !== null;
    }

    /** Label teks agunan sesuai skala ordinal C3 */
    public function labelAgunan(): string
    {
        return self::AGUNAN_LABELS[$this->C3_nilai_agunan] ?? '—';
    }

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah', 'id_nasabah');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    public function hasilPerhitungan(): HasOne
    {
        return $this->hasOne(HasilPerhitungan::class, 'id_pengajuan', 'id_pengajuan');
    }

    /** Kembalikan nilai kriteria sebagai array berurutan [C1, C2, C3, C4, C5] */
    public function nilaiKriteria(): array
    {
        return [
            $this->C1_laba_usaha,
            $this->C2_pendapatan_bersih,
            $this->C3_nilai_agunan,
            $this->C4_besar_pembiayaan,
            $this->C5_jangka_waktu,
        ];
    }
}
