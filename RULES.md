# RULES.md — Blueprint Teknis Implementasi

**Proyek:** Sistem Pendukung Keputusan Penentuan Kelayakan Pemberian Pembiayaan Nasabah pada KSPPS Berkah Sakinah Almughni Girimarto Menggunakan Metode Weighted Product (WP)
**Sumber:** Draf Skripsi Bab I–III (acuan tunggal, satu-satunya rujukan kebenaran).
**Tujuan dokumen:** Dipakai oleh AI coding agent sebagai instruksi pembangunan kode. Semua keputusan teknis WAJIB konsisten dengan isi dokumen ini. Bila ada konflik dengan asumsi default framework, isi dokumen ini menang.

---

## 1. PROFIL PROYEK & TECH STACK

### 1.1 Identitas Sistem
- **Nama sistem:** Sistem Pendukung Keputusan Pembiayaan KSPPS (selanjutnya disebut "Sistem").
- **Studi kasus:** KSPPS Berkah Sakinah Almughni, Kecamatan Girimarto, Kabupaten Wonogiri.
- **Aktor terotentikasi:** dua peran — `Petugas Pembiayaan` (operasional: input nasabah, pengajuan, nilai kriteria, perhitungan WP, penetapan keputusan, cetak laporan) dan `Administrator` (manajemen pengguna, kriteria & bobot, periode, audit log, pengaturan sistem).
- **Sifat sistem:** berbasis web, non-pengganti keputusan manusia. Sistem menghasilkan skor preferensi terkalibrasi; keputusan akhir tetap pada Petugas Pembiayaan.
- **Karakter algoritma:** non-kompensatori (sesuai prinsip kehati-hatian pembiayaan syariah).

### 1.2 Tech Stack (mengacu Tabel 3.3 dokumen)

| Komponen | Spesifikasi Wajib |
|---|---|
| Sistem Operasi pengembangan | Microsoft Windows 11 |
| Local Development Environment | LaraGonzo v6 build 250505 (fork Laragon) dengan Apache, PHP, dan MariaDB terisolasi |
| Bahasa Pemrograman | PHP 8.3.20; HTML5; CSS3; JavaScript ES2020 |
| Framework Back-end | Laravel 11 (Eloquent ORM, migration, Pest testing) |
| Framework Front-end | Bootstrap 5; Blade Component |
| Asset Bundler | Vite (bawaan Laravel 11) |
| DBMS | MariaDB 11.x |
| Web Server | Apache HTTP Server v2.4.63 (terintegrasi LaraGonzo) |
| Editor Kode | Visual Studio Code |
| Peramban target | Google Chrome, Microsoft Edge |
| Perangkat Pemodelan | Draw.io (DFD, flowchart, ERD); StarUML (Use Case) |
| Perangkat Perancangan Antarmuka | Figma (wireframe & mockup) |
| Version Control | Git, repositori GitHub |
| Manajer Referensi | Mendeley Reference Manager |

### 1.3 Spesifikasi Perangkat Keras Acuan (Tabel 3.2)
Laptop Acer Aspire 5, prosesor AMD Ryzen 5500U, RAM 16 GB DDR4, SSD 512 GB, layar 14" Full HD (1920 × 1080), kartu jaringan Wi-Fi 5 (IEEE 802.11ac).

### 1.4 Konvensi Arsitektur Wajib
- **Pemisahan logika perhitungan WP:** WAJIB diletakkan di service class `app/Services/WeightedProductService.php`. Controller TIDAK boleh mengandung logika matematis WP.
- **Skema basis data** dikelola melalui fitur **migration** Laravel sehingga versi skema tercatat di repositori Git.
- **Antarmuka responsif** menggunakan komponen Bootstrap 5 yang dikompilasi melalui Vite.
- **Unit test** logika WP harus dapat dijalankan tanpa simulasi request HTTP (Pest).

---

## 2. SKEMA DATABASE (ERD, dinormalisasi hingga 3NF)

Delapan entitas inti sebagaimana digambarkan pada Gambar 3.4 dokumen. Tipe data berikut adalah turunan presisi dari ERD; nama field disalin persis dari ERD.

### 2.1 Entitas `pengguna`
Peran: kredensial dan otorisasi aktor sistem (admin/petugas).

| Field | Tipe Data | Keterangan |
|---|---|---|
| `id_pengguna` | BIGINT UNSIGNED, PK, AUTO_INCREMENT | Primary key |
| `username` | VARCHAR(50), UNIQUE, NOT NULL | Username login |
| `password` | VARCHAR(255), NOT NULL | Hash (bcrypt) |
| `nama` | VARCHAR(100), NOT NULL | Nama lengkap |
| `peran` | ENUM('admin','petugas'), NOT NULL | Role aktor |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

### 2.2 Entitas `nasabah`
Peran: data master nasabah pemohon pembiayaan.

| Field | Tipe Data | Keterangan |
|---|---|---|
| `id_nasabah` | BIGINT UNSIGNED, PK, AUTO_INCREMENT | Primary key |
| `no_anggota` | VARCHAR(30), UNIQUE, NOT NULL | Nomor keanggotaan KSPPS |
| `nama_nasabah` | VARCHAR(100), NOT NULL | |
| `alamat` | TEXT | |
| `no_telp` | VARCHAR(20) | |
| `jenis_usaha` | VARCHAR(100) | |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

### 2.3 Entitas `kriteria`
Peran: definisi kriteria C1–C5 dan parameter pembobotannya.

| Field | Tipe Data | Keterangan |
|---|---|---|
| `id_kriteria` | BIGINT UNSIGNED, PK, AUTO_INCREMENT | |
| `kode_kriteria` | VARCHAR(5), UNIQUE, NOT NULL | C1, C2, C3, C4, C5 |
| `nama_kriteria` | VARCHAR(100), NOT NULL | |
| `bobot_mentah` | TINYINT UNSIGNED, NOT NULL | Skala 1–5 |
| `bobot_normalisasi` | DECIMAL(10,6), NOT NULL | Hasil normalisasi (boleh negatif) |
| `tipe` | ENUM('benefit','cost'), NOT NULL | |
| `satuan` | VARCHAR(30) | rupiah / bulan / ordinal |

### 2.4 Entitas `periode`
Peran: periode mingguan, satuan agregasi vektor V.

| Field | Tipe Data | Keterangan |
|---|---|---|
| `id_periode` | BIGINT UNSIGNED, PK, AUTO_INCREMENT | |
| `kode_periode` | VARCHAR(20), UNIQUE, NOT NULL | misal `2024-W14` |
| `tanggal_mulai` | DATE, NOT NULL | |
| `tanggal_selesai` | DATE, NOT NULL | |
| `status` | ENUM('aktif','tutup'), NOT NULL | |
| `created_at` | TIMESTAMP | |

### 2.5 Entitas `pengajuan`
Peran: satu rekord = satu pengajuan pembiayaan oleh nasabah pada satu periode.

| Field | Tipe Data | Keterangan |
|---|---|---|
| `id_pengajuan` | BIGINT UNSIGNED, PK, AUTO_INCREMENT | |
| `id_nasabah` | BIGINT UNSIGNED, FK → `nasabah.id_nasabah` | |
| `id_periode` | BIGINT UNSIGNED, FK → `periode.id_periode` | |
| `C1_laba_usaha` | DECIMAL(15,2), NOT NULL | Rupiah |
| `C2_pendapatan_bersih` | DECIMAL(15,2), NOT NULL | Rupiah |
| `C3_nilai_agunan` | TINYINT UNSIGNED, NOT NULL | Ordinal 1–4 |
| `C4_besar_pembiayaan` | DECIMAL(15,2), NOT NULL | Rupiah |
| `C5_jangka_waktu` | SMALLINT UNSIGNED, NOT NULL | Bulan |
| `tanggal_pengajuan` | DATE, NOT NULL | |

### 2.6 Entitas `hasil_perhitungan`
Peran: menyimpan skor S, skor V, ranking, dan status klasifikasi per pengajuan.

| Field | Tipe Data | Keterangan |
|---|---|---|
| `id_hasil` | BIGINT UNSIGNED, PK, AUTO_INCREMENT | |
| `id_pengajuan` | BIGINT UNSIGNED, FK → `pengajuan.id_pengajuan` | |
| `vektor_S` | DECIMAL(20,8), NOT NULL | Skor absolut |
| `vektor_V` | DECIMAL(20,8), NOT NULL | Skor relatif (per periode) |
| `ranking` | SMALLINT UNSIGNED | Hanya untuk status diterima |
| `status` | ENUM('diterima','ditolak'), NOT NULL | |
| `created_at` | TIMESTAMP | |

### 2.7 Entitas `log_keputusan`
Peran: jejak audit setiap keputusan akhir oleh Petugas Pembiayaan.

| Field | Tipe Data | Keterangan |
|---|---|---|
| `id_log` | BIGINT UNSIGNED, PK, AUTO_INCREMENT | |
| `id_pengguna` | BIGINT UNSIGNED, FK → `pengguna.id_pengguna` | |
| `id_hasil_perhitungan` | BIGINT UNSIGNED, FK → `hasil_perhitungan.id_hasil` | |
| `keputusan_akhir` | ENUM('diterima','ditolak','diprioritaskan'), NOT NULL | |
| `catatan` | TEXT | |
| `timestamp` | TIMESTAMP, NOT NULL | |

### 2.8 Entitas `bobot_history`
Peran: riwayat versi bobot kriteria per periode (untuk rekalibrasi & audit).

| Field | Tipe Data | Keterangan |
|---|---|---|
| `id_bobot` | BIGINT UNSIGNED, PK, AUTO_INCREMENT | |
| `id_periode` | BIGINT UNSIGNED, FK → `periode.id_periode` | |
| `id_kriteria` | BIGINT UNSIGNED, FK → `kriteria.id_kriteria` | |
| `bobot_mentah` | TINYINT UNSIGNED, NOT NULL | |
| `bobot_normalisasi` | DECIMAL(10,6), NOT NULL | |
| `created_at` | TIMESTAMP | |

### 2.9 Relasi Antar Entitas
- `nasabah` (1) — (N) `pengajuan`
- `periode` (1) — (N) `pengajuan`
- `pengajuan` (1) — (1) `hasil_perhitungan`
- `hasil_perhitungan` (1) — (N) `log_keputusan`
- `pengguna` (1) — (N) `log_keputusan`
- `periode` (1) — (N) `bobot_history`
- `kriteria` (1) — (N) `bobot_history`

---

## 3. OPERASIONALISASI KRITERIA & BOBOT

### 3.1 Kriteria (Tabel 2.1 dokumen)

| Kode | Kriteria | Atribut | Bobot Awal | Satuan / Skala |
|---|---|---|---|---|
| C1 | Laba Usaha | Benefit | 5 | Rupiah |
| C2 | Pendapatan Bersih | Benefit | 4 | Rupiah |
| C3 | Nilai Agunan | Benefit | 4 | Ordinal (1–4) |
| C4 | Besar Pembiayaan | Cost | 2 | Rupiah |
| C5 | Jangka Waktu | Cost | 2 | Bulan |
| **Total** | | | **17** | |

### 3.2 Skala Ordinal C3 (Nilai Agunan)
- `1` = Tanpa Agunan
- `2` = BPKB sepeda motor
- `3` = BPKB mobil
- `4` = Sertifikat tanah / bangunan

C3 secara matematis diperlakukan sebagai variabel rasio pada operasi pemangkatan WP (selisih antarkategori dianggap setara). Hal ini didokumentasikan sebagai keterbatasan; sistem tidak melakukan transformasi tambahan terhadap C3.

### 3.3 Aturan Input
- C1, C2, C4 = nilai nominal rupiah, tipe `DECIMAL(15,2)`, nilai > 0.
- C3 = bilangan bulat ∈ {1, 2, 3, 4}.
- C5 = bilangan bulat positif (bulan).
- Tidak ada normalisasi min-max sebelum perhitungan WP (lihat §4).

### 3.4 Bobot 5-4-4-2-2 (default)
Bobot dipasang sebagai *seed* awal sistem. Bobot tersimpan di tabel `kriteria` dan tercatat versinya di `bobot_history`. Administrator dapat mengubah bobot, namun setiap perubahan WAJIB menghasilkan rekord baru di `bobot_history`.

---

## 4. LOGIKA MATEMATIS WEIGHTED PRODUCT (WP)

### 4.1 Langkah 1 — Penyusunan Matriks Keputusan
Matriks `X` berukuran `m × n`, m = jumlah alternatif (pengajuan) pada satu periode, n = 5 kriteria, urutan kolom: C1, C2, C3, C4, C5. Nilai dimasukkan dalam bentuk aslinya tanpa transformasi.

### 4.2 Langkah 2 — Normalisasi Bobot (Persamaan 2.1)

```
w_j = (s_j × W_j) / Σ |W_j|

dengan s_j = +1 untuk benefit
      s_j = −1 untuk cost
```

Aturan implementasi:
- Penjumlahan `Σ |W_j|` dilakukan terhadap **nilai absolut** bobot mentah seluruh kriteria.
- Hasil normalisasi menjamin `Σ |w_j| = 1`.
- Tanda `s_j` MELEKAT pada hasil normalisasi (negatif untuk cost).

Untuk bobot default `W = (5, 4, 4, 2, 2)` dengan tipe `(benefit, benefit, benefit, cost, cost)` dan total = 17, hasil normalisasi (acuan presisi dokumen):

| Kriteria | s_j | W_j | w_j (ternormalisasi) |
|---|---|---|---|
| C1 | +1 | 5 | +0.2941 |
| C2 | +1 | 4 | +0.2353 |
| C3 | +1 | 4 | +0.2353 |
| C4 | −1 | 2 | −0.1176 |
| C5 | −1 | 2 | −0.1176 |
| Σ\|w_j\| | | | ≈ 1.0000 |

### 4.3 Langkah 3 — Perhitungan Vektor S (Persamaan 2.2)

```
S_i = Π (X_ij)^(w_j),   j = 1, 2, …, n
```

Aturan implementasi WAJIB:
1. **Nilai `X_ij` dimasukkan dalam bentuk asli** (rupiah, ordinal, bulan) — TANPA normalisasi min-max ke rentang [0,1].
2. Eksponen `w_j` bertanda mengikuti `s_j` (negatif untuk cost = ekuivalen pembagian).
3. Perhitungan menggunakan **double precision** (`pow()` PHP atau `bcpow` jika presisi tambahan dibutuhkan).
4. Hasil perhitungan WAJIB diverifikasi paralel terhadap spreadsheet sebagai *ground truth* saat unit testing.
5. Konsekuensi: besaran absolut `S_i` bergantung pada satuan dan rentang data masukan (orde ratusan pada data nyata KSPPS).

### 4.4 Langkah 4 — Perhitungan Vektor V (Persamaan 2.3)

```
V_i = S_i / Σ S_i,   i = 1, 2, …, m
```

Aturan implementasi WAJIB:
1. `V_i` dihitung **per periode mingguan**, BUKAN secara kumulatif lintas periode.
2. Denominator `Σ S_i` hanya mencakup pengajuan dalam `id_periode` yang sama.
3. Untuk setiap periode aktif, `Σ V_i = 1` (atau 100%).
4. `V_i` digunakan **hanya** untuk perangkingan prioritas pencairan, BUKAN untuk klasifikasi.

### 4.5 Pemisahan Peran S vs V
| Aspek | Vektor S | Vektor V |
|---|---|---|
| Sifat | Skor absolut | Skor relatif |
| Dipakai untuk | Klasifikasi diterima/ditolak via ambang θ | Perangkingan prioritas pencairan |
| Sensitif terhadap | Satuan & rentang data | Komposisi himpunan alternatif periode |
| Lintas periode | Stabil | Tidak dapat dibandingkan |

---

## 5. CLASSIFICATION THRESHOLD & RECALIBRATION

### 5.1 Ambang Batas Absolut (default)
```
Status = "Diterima"  jika S_i ≥ 250
Status = "Ditolak"   jika S_i < 250
```

Nilai `θ = 250` diturunkan dari analisis distribusi 20 data historis (Tabel 2.2 dokumen):
- Populasi Ditolak (n = 4): `S_i ∈ [172.02, 241.71]`
- Populasi Diterima (n = 16): `S_i ∈ [270.59, 550.74]`
- *Separable gap*: `[241.71, 270.59]`, lebar 28.88
- `θ = 250` dipilih sebagai titik tengah gap (margin ≈ 8 unit terhadap Ditolak, ≈ 20 unit terhadap Diterima).

`θ` disimpan di tabel konfigurasi sistem (dapat diakses melalui modul Administrator) sebagai parameter dinamis bertipe `DECIMAL(10,4)`.

### 5.2 Perangkingan Mingguan Berbasis Vektor V
Setelah klasifikasi:
1. Ambil seluruh pengajuan berstatus `Diterima` pada periode aktif.
2. Urutkan menurun berdasarkan `V_i`.
3. **Top 1–5** ditandai sebagai status keputusan akhir `Diprioritaskan` (dasar: keterbatasan alokasi anggaran pembiayaan mingguan KSPPS, BUKAN ambang skor tambahan).

> Catatan presisi: dokumen menyebut "Top 5" sebagai cluster prioritas mingguan (lihat Sub Bab 3.3.3 Langkah 6 dan rancangan dasbor Gambar 3.7). Implementasi menggunakan parameter `top_n = 5` sebagai default; nilai ini dapat dikonfigurasi Administrator namun TIDAK boleh diubah pada level kode keras.

Sisa nasabah berstatus Diterima (rank 6 ke bawah) berstatus `Diterima (tidak prioritas)`.

### 5.3 Algoritma Rekalibrasi Ambang (Modul Administrator)
Prosedur baku (mengikuti Sub Bab 2.2.4 paragraf rekalibrasi):

**Prasyarat:** minimal **20 kasus terbaru** dengan keputusan riil tersedia di basis data.

**Langkah:**
1. Administrator memilih jendela data (≥ 20 kasus berkeputusan riil).
2. Sistem menghitung ulang `S_i` seluruh kasus menggunakan bobot ternormalisasi terkini.
3. Sistem memisahkan kasus menjadi dua populasi: `Diterima_riil` dan `Ditolak_riil` (berdasarkan kolom keputusan riil pada `log_keputusan`).
4. Hitung:
   - `max_ditolak = max(S_i ∈ Ditolak_riil)`
   - `min_diterima = min(S_i ∈ Diterima_riil)`
5. **Cabang algoritma:**
   - **Kasus A — Separable gap ada** (`min_diterima > max_ditolak`):
```
     θ_baru = round((max_ditolak + min_diterima) / 2)
```
     Bila perlu nilai bulat, gunakan integer di tengah interval `[max_ditolak, min_diterima]`.
   - **Kasus B — Populasi tumpang tindih** (`min_diterima ≤ max_ditolak`):
     Lakukan *linear search* sepanjang himpunan kandidat (himpunan seluruh nilai `S_i` pada area tumpang tindih).
     Untuk setiap kandidat `θ_c`, hitung total kesalahan klasifikasi:
```
     FA(θ_c)  = |{ i ∈ Ditolak_riil  : S_i ≥ θ_c }|   // false acceptance
     FR(θ_c)  = |{ i ∈ Diterima_riil : S_i <  θ_c }|   // false rejection
     err(θ_c) = FA(θ_c) + FR(θ_c)
```
     Pilih `θ_baru = argmin_{θ_c} err(θ_c)`. Jika terdapat seri, ambil nilai tengah dari himpunan optimum.
6. Tampilkan visualisasi distribusi S_i kedua populasi sebelum dan sesudah penerapan `θ_baru` pada antarmuka administrator.
7. Konfirmasi administrator → simpan `θ_baru` sebagai parameter aktif; catat perubahan pada tabel audit.

### 5.4 Rekalibrasi Otomatis Sebagai Pemicu
Rekalibrasi WAJIB ditawarkan (bukan otomatis dipaksakan) ketika:
- Plafon pembiayaan berubah.
- Profil rata-rata laba usaha anggota bergeser signifikan.
- Bobot kriteria diperbarui Administrator.
- Distribusi `S_i` 20 kasus terakhir memberikan akurasi terhadap keputusan riil < ambang minimum operasional (default 90%, dapat diatur).

---

## 6. GOLD STANDARD DATASET (20 NASABAH HISTORIS)

Sumber: Tabel 3.1 dokumen. Disalin utuh. Dataset ini WAJIB dipakai sebagai data seeder (`database/seeders/NasabahHistorisSeeder.php`) dan basis testing LOOCV.

| No. | Nama Nasabah | C1 (Rp) | C2 (Rp) | C3 | C4 (Rp) | C5 (bln) |
|---|---|---:|---:|:-:|---:|:-:|
| 1 | Eky Setyoningsih | 6.100.000 | 1.600.000 | 2 | 15.000.000 | 24 |
| 2 | Suharni | 7.200.000 | 2.100.000 | 4 | 30.000.000 | 36 |
| 3 | Suradi | 5.100.000 | 1.100.000 | 3 | 5.000.000 | 12 |
| 4 | Padi Irokromo | 7.100.000 | 4.200.000 | 4 | 40.000.000 | 24 |
| 5 | Pardi | 3.500.000 | 200.000 | 1 | 1.500.000 | 24 |
| 6 | Budianto | 3.000.000 | 2.000.000 | 4 | 2.000.000 | 10 |
| 7 | Samiyo | 2.100.000 | 1.650.000 | 4 | 15.000.000 | 24 |
| 8 | Maryanto | 2.000.000 | 2.000.000 | 2 | 5.000.000 | 36 |
| 9 | Supriyanto | 1.700.000 | 300.000 | 1 | 1.500.000 | 15 |
| 10 | Kasiman | 4.500.000 | 1.400.000 | 2 | 10.000.000 | 18 |
| 11 | Timo | 2.000.000 | 200.000 | 2 | 2.500.000 | 36 |
| 12 | Parto | 4.350.000 | 1.500.000 | 4 | 21.500.000 | 36 |
| 13 | Muladi | 8.400.000 | 4.900.000 | 4 | 35.000.000 | 18 |
| 14 | Suyato | 9.300.000 | 4.700.000 | 3 | 22.000.000 | 12 |
| 15 | Sutarti | 8.100.000 | 1.600.000 | 4 | 15.000.000 | 24 |
| 16 | Padi | 3.050.000 | 1.100.000 | 4 | 7.000.000 | 18 |
| 17 | Sugiyarto | 1.800.000 | 500.000 | 2 | 2.000.000 | 12 |
| 18 | Suparlan | 3.400.000 | 600.000 | 4 | 5.000.000 | 24 |
| 19 | Nariyadi | 6.200.000 | 2.700.000 | 2 | 25.000.000 | 24 |
| 20 | Yanto | 4.600.000 | 500.000 | 2 | 4.000.000 | 24 |

### 6.1 Nilai S_i Acuan (Verifikasi Implementasi)
Tiga titik verifikasi WAJIB dari dokumen (Tabel 3.6):

| Nasabah | S_i acuan |
|---|---:|
| Supriyanto | 180.4084 |
| Sutarti | 423.3871 |
| Suyato | 550.7393 |

Total `Σ S_i` untuk 20 data acuan dokumen = **6.754,82** (dipakai sebagai denominator V_i pada perhitungan kumulatif demonstratif, lihat Tabel 3.7).

### 6.2 Status Riil Acuan (untuk LOOCV)
Berdasarkan analisis distribusi Tabel 2.2 dokumen: 16 nasabah berstatus **Diterima** dan 4 nasabah berstatus **Ditolak**. Empat nasabah dengan `S_i` pada rentang `[172.02, 241.71]` masuk populasi Ditolak; sisanya Diterima. Implementasi seeder WAJIB menyetel kolom `keputusan_riil` per nasabah agar dapat divalidasi terhadap ambang θ.

> Catatan presisi: dokumen tidak melampirkan tabel "siapa Diterima vs siapa Ditolak" secara eksplisit per nama. Implementasi menetapkan status riil melalui penghitungan `S_i` pada bobot default dan penerapan ambang θ = 250 sebagai bootstrap awal. Setelah deployment, kolom `keputusan_riil` diisi oleh Petugas Pembiayaan dari arsip lembaga dan akan menjadi *gold standard* yang menggantikan bootstrap tersebut.

---

## 7. ATURAN EVALUASI & VALIDASI SISTEM

### 7.1 Lapisan Pengujian (tiga lapis sesuai Sub Bab 3.3.4)

#### 7.1.1 Lapis 1 — Pengujian Fungsional (Black-Box Testing)
Cakupan modul yang WAJIB diuji:
1. Login & otentikasi (dua peran).
2. Manajemen pengguna (CRUD, hanya Administrator).
3. Manajemen kriteria & bobot (dengan pencatatan ke `bobot_history`).
4. Manajemen periode mingguan (status aktif/tutup).
5. Input data nasabah (CRUD).
6. Input pengajuan (validasi tipe data sesuai §3.3).
7. Eksekusi perhitungan WP per periode aktif.
8. Tampilan hasil & ranking.
9. Penetapan keputusan & pencatatan `log_keputusan`.
10. Cetak laporan (PDF / Excel).
11. Modul audit log.
12. Modul rekalibrasi ambang.

Kriteria lulus: setiap *test case* black-box berstatus PASS (output sesuai spesifikasi fungsional, tanpa simulasi internal).

#### 7.1.2 Lapis 2 — Pengujian Akurasi Klasifikasi (LOOCV)
**Skema:** Leave-One-Out Cross-Validation pada n = 20 data historis.

**Alasan pemilihan LOOCV** (dokumen Bab 3.1 & 2.2.4): pada `n = 20`, pembagian holdout (14:6 atau setara) menghasilkan varians estimasi yang tinggi; LOOCV memanfaatkan setiap data sebagai uji sebanyak satu kali sehingga estimasi akurasi stabil.

**Prosedur LOOCV:**
```
Untuk i = 1 hingga 20:
    train_set ← 19 data (selain i)
    test_set  ← {data ke-i}
    Hitung θ_i melalui algoritma kalibrasi (Bagian §5.3) pada train_set
    Hitung S_i_test untuk data uji
    Prediksi_i ← "Diterima" jika S_i_test ≥ θ_i, selain itu "Ditolak"
    Bandingkan Prediksi_i terhadap keputusan_riil_i → catat hasil
Selesai
```

**Metrik wajib dilaporkan** (atas confusion matrix agregat 20 fold):
- Akurasi
- Presisi
- Recall (sensitivitas)
- F1-score
- Confusion matrix lengkap (TP, TN, FP, FN)

Modul evaluasi WAJIB tersedia di antarmuka administrator dengan tombol "Jalankan LOOCV" yang menampilkan keempat metrik dan confusion matrix.

#### 7.1.3 Lapis 3 — Analisis Sensitivitas Terhadap Bobot
**Tujuan:** menguji kestabilan peringkat **lima besar** terhadap perubahan komposisi bobot.

**Tiga skenario WAJIB diuji** (Sub Bab 3.3.4):

| Skenario | Nama | W = (C1, C2, C3, C4, C5) | Total | Catatan |
|---|---|---|---:|---|
| S0 | Bobot asli | (5, 4, 4, 2, 2) | 17 | Default sistem |
| S1 | Penekanan kapasitas | (6, 5, 4, 2, 2) | 19 | C1 & C2 ditingkatkan |
| S2 | Bobot setara | (3, 3, 3, 3, 3) | 15 | Semua kriteria setara |

**Output analisis sensitivitas** untuk masing-masing skenario:
1. Daftar lima besar berdasarkan `V_i`.
2. Status klasifikasi (Diterima/Ditolak) setelah ambang θ (untuk S1 dan S2 ambang dikalibrasi ulang via §5.3 pada 20 data acuan).
3. Tabel perbandingan ranking 1–5 lintas tiga skenario.
4. Indikator kestabilan: berapa nasabah top-5 yang konsisten di S0, S1, dan S2.

Modul analisis sensitivitas tersedia di area Administrator.

### 7.2 Verifikasi Numerik WP (Acceptance Criteria Unit Test)
Setiap build WAJIB melewati assertion berikut pada `tests/Unit/WeightedProductServiceTest.php`:

```
assert  | bobot_normalisasi(C1) ≈ +0.2941   (toleransi 1e-4)
assert  | bobot_normalisasi(C4) ≈ −0.1176   (toleransi 1e-4)
assert  | Σ |w_j| ≈ 1.0000                 (toleransi 1e-4)
assert  | S(Supriyanto) ≈ 180.4084         (toleransi 1e-2)
assert  | S(Sutarti)    ≈ 423.3871         (toleransi 1e-2)
assert  | S(Suyato)     ≈ 550.7393         (toleransi 1e-2)
assert  | Σ S_i (20 data) ≈ 6754.82        (toleransi 1e-1)
assert  | Σ V_i (20 data) ≈ 1.0000         (toleransi 1e-4)
```

Bila salah satu assertion gagal, build dianggap **gagal** dan tidak boleh di-merge.

### 7.3 Keterbatasan yang Wajib Dicantumkan di README Sistem
Sesuai Bab 3.1 dokumen, tiga keterbatasan WAJIB dicantumkan secara eksplisit pada dokumentasi sistem:
1. **Ukuran sampel terbatas (n = 20).** Mitigasi: LOOCV.
2. **C3 ordinal diperlakukan rasio pada operasi pemangkatan WP.** Mitigasi: pemeriksaan konsistensi pasangan nasabah berprofil identik kecuali C3.
3. **Bobot 5-4-4-2-2 bersifat expert judgment** (bukan AHP atau prosedur formal lain). Mitigasi: analisis sensitivitas tiga skenario.

---

## 8. ATURAN ANTARMUKA & ALUR PENGGUNA (RINGKAS)

Mengacu pada sitemap Gambar 3.5 dokumen, struktur navigasi WAJIB:

```
/ (publik)
└── /login
    └── /dashboard
        ├── Area Petugas Pembiayaan
        │    ├── /nasabah
        │    ├── /pengajuan
        │    ├── /pengajuan/create  (input nilai kriteria)
        │    ├── /perhitungan/wp    (hitung WP per periode)
        │    ├── /hasil             (hasil & ranking)
        │    └── /keputusan         (tetapkan keputusan & cetak laporan)
        └── Area Administrator
             ├── /admin/pengguna
             ├── /admin/kriteria    (kelola kriteria & bobot)
             ├── /admin/periode
             ├── /admin/audit
             ├── /admin/threshold   (rekalibrasi θ — §5.3)
             └── /admin/sensitivitas (analisis sensitivitas — §7.1.3)
```

Halaman umum (kedua peran): `/profil`, `/logout`.

**Indikator visual kriteria:** label `B` (benefit) dan `C` (cost) WAJIB ditampilkan di samping setiap kolom isian kriteria pada halaman penilaian (mengacu Gambar 3.8).

---

## 9. PENCATATAN AUDIT (NON-NEGOTIABLE)

Setiap aksi berikut WAJIB tercatat:

| Aksi | Tabel target |
|---|---|
| Login/logout pengguna | `log_keputusan` (kategori akses) atau tabel audit terpisah jika tersedia |
| Perubahan bobot kriteria | `bobot_history` |
| Pembukaan/penutupan periode | tabel audit |
| Eksekusi perhitungan WP | `hasil_perhitungan` |
| Penetapan keputusan akhir | `log_keputusan` |
| Rekalibrasi ambang θ | tabel audit (dengan nilai θ lama & baru) |
| Eksekusi LOOCV / Sensitivitas | tabel audit |

---

## 10. RINGKASAN ATURAN MUTLAK (HARD CONSTRAINTS)

1. WAJIB Laravel 11 + PHP 8.3.x + MariaDB 11.x + Bootstrap 5 + Vite.
2. WAJIB logika WP terisolasi di `app/Services/WeightedProductService.php`.
3. WAJIB nilai atribut dipakai dalam bentuk asli (tanpa min-max normalization).
4. WAJIB eksponen bertanda sesuai tipe atribut (benefit positif, cost negatif).
5. WAJIB V_i dihitung per periode mingguan, BUKAN kumulatif.
6. WAJIB θ default = 250; perubahan hanya melalui modul rekalibrasi (§5.3).
7. WAJIB Top-5 V_i = `Diprioritaskan`.
8. WAJIB seeder memuat 20 nasabah historis sesuai Tabel 3.1.
9. WAJIB unit test melewati keseluruhan assertion §7.2.
10. WAJIB modul LOOCV dan modul Analisis Sensitivitas (3 skenario: S0=5-4-4-2-2, S1=6-5-4-2-2, S2=3-3-3-3-3) tersedia di area Administrator.
11. WAJIB jejak audit pada setiap aksi penting (§9).
12. DILARANG mengubah konstanta numerik (bobot default, θ default, skala ordinal C3) di tingkat kode keras; semua harus terkonfigurasi via tabel basis data.

---

**Akhir RULES.md** — dokumen ini adalah satu-satunya acuan kebenaran teknis. Setiap penyimpangan dari aturan di atas WAJIB direview dan disetujui sebelum di-merge.