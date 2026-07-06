# DESIGN.md — Sistem Desain Antarmuka

**Proyek:** Sistem Pendukung Keputusan Pembiayaan KSPPS Berkah Sakinah Almughni Girimarto
**Pasangan dokumen:** Dibaca berdampingan dengan `RULES.md`. Bila `DESIGN.md` (lapisan visual) berbenturan dengan `RULES.md` (lapisan fungsional, matematis, dan rute aplikasi), `RULES.md` selalu menang. Tidak ada perubahan rute, nama controller, atau penamaan field basis data yang diizinkan dari sisi desain.
**Audiens dokumen:** AI coding agent serta developer manusia yang menyusun lapisan presentasi.
**Pengguna akhir sistem:** Petugas Pembiayaan dan Administrator KSPPS yang dalam banyak kasus tidak berlatar belakang teknologi informasi. Setiap keputusan desain diukur dari pertanyaan: *apakah seorang petugas usia 45 tahun yang baru pertama kali memakai aplikasi ini dapat memahami layar dalam 10 detik?* Jika tidak, desain wajib disederhanakan.
**Sasaran kualitatif:** antarmuka berwibawa khas *fintech syariah enterprise* — tenang, kredibel, dan sangat mudah dipindai mata. Bukan dasbor demo Tailwind yang penuh warna, bukan template administrasi gratisan, bukan tampilan kaku khas aplikasi pemerintahan lama.

---

## 1. REVOLUSI ESTETIKA FINTECH SYARIAH

Bagian ini menggantikan keseluruhan palet, tipografi, dan filosofi visual lama yang dinilai terlalu monoton dan kusam. Tujuannya menghadirkan antarmuka yang elegan, hangat, dan tepercaya tanpa mengorbankan ketenangan profesional.

### 1.1 Empat Postulat Desain

Empat prinsip berikut bersifat mengikat. Setiap pull request yang melanggarnya wajib direvisi sebelum digabung.

Pertama, *tenang dulu, ekspresif kemudian*. Pengguna utama adalah Petugas Pembiayaan yang membaca angka rupiah setiap hari. Antarmuka harus mengurangi beban kognitif, bukan menambahnya. Warna pekat hanya muncul sebagai sinyal status, tidak sebagai dekorasi.

Kedua, *data adalah subjek, antarmuka adalah figuran*. Wadah seperti kartu, tabel, dan panel dirancang untuk surut ke latar agar nominal pembiayaan, skor preferensi, dan status keputusan menjadi fokus mata. Kontras tinggi hanya diberikan kepada data, bukan kepada bingkai.

Ketiga, *konsistensi geometris*. Sudut, jarak, dan ketebalan garis tidak boleh dipilih sembarangan. Sistem mengikuti satu skala spasi (4–8–12–16–24–32–48–64 piksel) dan satu skala radius (6 piksel untuk input dan tombol, 8 piksel untuk kartu, 12 piksel untuk kartu KPI dan modal, 999 piksel untuk badge berbentuk pil).

Keempat, *identitas syariah modern tanpa ornamen*. Karakter syariah disampaikan melalui ketenangan, kebersihan tipografi, dan kepercayaan visual. Tidak ada pola arabesque, kaligrafi dekoratif, atau ornamen bulan-bintang pada lapisan antarmuka. Aksen hijau zamrud dipakai hemat sebagai penegas profesionalisme.

### 1.2 Palet Warna Humanis dan Tepercaya

Palet baru meninggalkan abu-abu dingin yang sebelumnya menimbulkan kesan kaku. Latar aplikasi memakai off-white hangat sehingga halaman terasa premium namun tetap ramah ditatap berjam-jam. Warna utama tetap *Deep Emerald Green* dengan kelengkapan kedalaman tint dan shade untuk memberi ruang ekspresi yang terkontrol.

Definisi resmi sebagai CSS Custom Properties, ditempatkan pada `resources/css/app.css` dan dijadikan rujukan oleh seluruh utility class Tailwind serta override variabel Bootstrap.

```css
:root {
  /* === BRAND (Emerald Hijau Zamrud) === */
  --color-primary-950: #082B22;   /* Shade terdalam, dipakai untuk hover gelap */
  --color-primary-900: #0E3B2E;   /* Warna utama tombol, link aktif, dan aksen */
  --color-primary-700: #14543F;   /* Hover state primary */
  --color-primary-500: #2D8A6B;   /* Tint sedang untuk garis aksen tipis */
  --color-primary-300: #7FC2A8;   /* Tint untuk grafik dan indikator lembut */
  --color-primary-100: #E6F1EC;   /* Soft tint, latar belakang halus */
  --color-primary-50:  #F2F8F5;   /* Permukaan kartu KPI yang sangat lembut */

  /* === SECONDARY (Slate / Charcoal untuk teks dan sidebar) === */
  --color-secondary-900: #0F1E2C; /* Slate pekat, sidebar gelap dan headline */
  --color-secondary-800: #1F2D3D; /* Slate variant untuk heading body */
  --color-secondary-600: #475569; /* Slate medium */
  --color-secondary-400: #94A3B8; /* Slate muted untuk meta */

  /* === MINT / TEAL (aksen pendukung syariah modern) === */
  --color-mint-500: #5EBFA0;      /* Aksen lembut untuk highlight non-kritis */
  --color-mint-100: #DCEFE7;      /* Latar lembut bagi notifikasi netral */
  --color-teal-700: #115E59;      /* Pasangan gradient akhir bagi primary */

  /* === SURFACE & BACKGROUND === */
  --color-bg-app: #F8FAFC;        /* Off-white hangat utama (rekomendasi A) */
  --color-bg-app-alt: #F3F4F6;    /* Alternatif off-white kedua (rekomendasi B) */
  --color-bg-surface: #FFFFFF;    /* Permukaan kartu, panel, modal */
  --color-bg-subtle: #F8FAFC;     /* Header tabel dan permukaan netral kedua */
  --color-bg-elevated: #FCFCFD;   /* Permukaan dropdown dan popover */
  --color-border: #E2E8F0;        /* Garis tipis universal */
  --color-border-strong: #CBD5E1; /* Garis pembatas seksi dan border input */

  /* === TYPOGRAPHY === */
  --color-text-strong: #0F1E2C;   /* Headline utama */
  --color-text-body: #1F2D3D;     /* Paragraf isi */
  --color-text-muted: #64748B;    /* Label sekunder, helper, timestamp */
  --color-text-inverse: #FFFFFF;  /* Teks di atas permukaan gelap */

  /* === STATUS BADGE (latar lembut + teks pekat) === */
  --color-status-priority-bg: #EEF2FF;
  --color-status-priority-fg: #3730A3;
  --color-status-priority-bd: #C7D2FE;

  --color-status-accept-bg:   #DCFCE7;
  --color-status-accept-fg:   #166534;
  --color-status-accept-bd:   #BBF7D0;

  --color-status-reject-bg:   #FEE2E2;
  --color-status-reject-fg:   #991B1B;
  --color-status-reject-bd:   #FECACA;

  --color-status-pending-bg:  #FEF3C7;
  --color-status-pending-fg:  #92400E;
  --color-status-pending-bd:  #FDE68A;

  /* === GRADIENT (mikro, sangat tipis) === */
  --gradient-primary-soft: linear-gradient(135deg, #14543F 0%, #0E3B2E 100%);
  --gradient-kpi-accent:   linear-gradient(180deg, #F2F8F5 0%, #FFFFFF 100%);

  /* === SHADOW === */
  --elev-1: 0 1px 2px rgba(15, 30, 44, 0.04), 0 1px 3px rgba(15, 30, 44, 0.03);
  --elev-2: 0 4px 12px rgba(15, 30, 44, 0.06), 0 2px 4px rgba(15, 30, 44, 0.04);
  --elev-3: 0 10px 24px rgba(15, 30, 44, 0.08);

  /* === FOCUS RING === */
  --color-focus-ring: rgba(14, 59, 46, 0.22);
}
```

Override pasangan Bootstrap 5 ditulis pada `resources/sass/_variables.scss` agar utility class bawaan Bootstrap (misal `btn-primary`, `text-primary`, `border-primary`) ikut menyesuaikan.

```scss
$primary:        #0E3B2E;
$secondary:      #1F2D3D;
$success:        #166534;
$danger:         #991B1B;
$warning:        #92400E;
$info:           #3730A3;
$body-bg:        #F8FAFC;
$body-color:     #1F2D3D;
$border-color:   #E2E8F0;
$enable-shadows:   false;
$enable-gradients: false;
$btn-focus-width:  3px;
$border-radius:     0.5rem;   /* 8 px untuk kartu */
$border-radius-sm:  0.375rem; /* 6 px untuk input/tombol */
$border-radius-lg:  0.75rem;  /* 12 px untuk modal & kartu KPI */
```

Daftar tegas hal yang dilarang dipakai pada palet: hijau neon, hijau Bootstrap mentah `#198754` sebagai background luas, kuning emas berkilau ala perbankan klise, serta gradient apa pun selain dua gradient mikro yang sudah ditetapkan di atas. Gradient bawaan Bootstrap di seluruh komponen tetap dimatikan.

### 1.3 Penggunaan Gradient Mikro

Gradient diizinkan secara terbatas. Tujuannya menghilangkan kesan datar yang sebelumnya membuat antarmuka terasa membosankan, tanpa menjatuhkan kewibawaannya.

Penerapan gradient hanya pada dua tempat. Pertama, *kartu KPI utama* pada dasbor menggunakan `--gradient-kpi-accent` (dari `#F2F8F5` ke `#FFFFFF`). Transisi ini sangat tipis sehingga di layar yang berbeda hampir tidak terlihat — itulah yang diinginkan. Kedua, *tombol primary penting* boleh memakai `--gradient-primary-soft` (gabungan emerald ke teal gelap) hanya pada tombol aksi utama formulir (`Simpan & Hitung`, `Terapkan Ambang Baru`, `Cetak Laporan`). Tombol primary lain di tabel atau toolbar tetap memakai warna solid `--color-primary-900` agar tidak ada inflasi visual.

Larangan keras: tidak ada gradient pada navbar, sidebar, kartu data biasa, badge, header tabel, atau ilustrasi. Tidak ada gradient yang melibatkan warna di luar palet di atas.

### 1.4 Tipografi yang Bersahabat

Hirarki teks dirancang agar petugas non-IT secara intuitif mengenali tiga hal sekaligus: mana yang bisa diklik, mana yang menjadi label data, dan mana yang merupakan ringkasan angka. Kejelasan hirarki ini lebih penting daripada kreativitas tipografi.

Keluarga font menggunakan Inter sebagai font utama, dengan rantai fallback Segoe UI lalu Roboto, lalu system sans-serif. Inter dimuat lokal via Vite — bukan Google Fonts CDN — karena koneksi internet di lokasi KSPPS tidak selalu stabil.

```css
--font-sans: 'Inter', 'Segoe UI', 'Roboto', system-ui, -apple-system, sans-serif;
--font-mono: 'JetBrains Mono', 'Consolas', 'Courier New', monospace;
```

Skala tipografi resmi sebagai berikut.

| Token utility | Pemakaian | Ukuran | Line-height | Weight |
|---|---|---|---|---|
| `text-display` | Angka besar pada kartu KPI | 36 px | 1.10 | 700 |
| `text-h1` | Judul halaman | 24 px | 1.25 | 700 |
| `text-h2` | Judul seksi besar | 20 px | 1.30 | 600 |
| `text-h3` | Judul kartu dan sub-seksi | 16 px | 1.40 | 600 |
| `text-body` | Paragraf dan isi tabel | 14 px | 1.55 | 400 |
| `text-body-strong` | Penegasan dalam paragraf | 14 px | 1.55 | 600 |
| `text-label` | Label form dan header tabel | 12 px | 1.40 | 600, uppercase, letter-spacing 0.04em |
| `text-meta` | Helper, timestamp, breadcrumb | 12 px | 1.45 | 400 |
| `text-numeric` | Nominal rupiah, S_i, V_i | 14 px | 1.40 | 500, font-variant-numeric: tabular-nums |

Penegasan ulang yang bersifat mengikat: setiap sel tabel yang berisi angka nominal rupiah, skor S_i, vektor V_i, ranking, dan persentase **wajib** memakai utility `tabular-nums`. Tanpa ini, digit "1" dan "7" akan saling menggeser ketika baris berganti dan kolom terlihat goyang — penyakit lama antarmuka keuangan yang harus dihindari.

Implementasi utility Tailwind yang harus disertakan pada setiap sel angka:

```html
<td class="text-end tabular-nums font-medium text-slate-800 px-4 py-3">
  {{ Number::currency($row->c1_laba_usaha, 'IDR', 'id', precision: 0) }}
</td>
```

### 1.5 Skala Spasi, Radius, dan Elevasi

Skala spasi mengikat: 4, 8, 12, 16, 24, 32, 48, 64 piksel. Tidak ada nilai di luar skala. Hal ini selaras dengan utility Tailwind `p-1` (4 px), `p-2` (8 px), `p-3` (12 px), `p-4` (16 px), `p-6` (24 px), `p-8` (32 px), dan `p-12` (48 px).

Skala radius mengikat: 6 piksel untuk input, dropdown, dan tombol biasa (`rounded-md`); 8 piksel untuk kartu standar (`rounded-lg`); 12 piksel untuk kartu KPI dan modal (`rounded-xl`); dan 999 piksel hanya untuk badge berbentuk pil (`rounded-full`). Tidak ada nilai 16, 20, atau 24 piksel pada komponen persegi panjang.

Sistem elevasi dibatasi tiga tingkat. Kartu pada keadaan diam memakai border tipis tanpa shadow. Tingkat 1 (`--elev-1`) aktif saat hover pada kartu klikabel. Tingkat 2 (`--elev-2`) dipakai untuk dropdown, popover, dan modal. Tingkat 3 (`--elev-3`) hanya untuk modal konfirmasi destruktif. Tidak ada shadow dengan blur lebih dari 24 piksel pada keseluruhan aplikasi.

---

## 2. PENINGKATAN UX UNTUK PETUGAS NON-IT

Bagian ini mengkodifikasi keputusan yang sengaja diambil agar petugas tanpa latar belakang IT bisa bekerja tanpa pelatihan formal yang panjang. Setiap aturan di sini lahir dari pengamatan bahwa kebingungan pengguna biasanya bukan karena fitur kompleks, melainkan karena penanda visual yang ambigu.

### 2.1 Petunjuk Visual yang Intuitif

Setiap menu, tombol aksi, dan label kartu wajib disertai ikon line-style yang mendukung makna teks. Ikon bukan dekorasi, melainkan jangkar pengenalan cepat sebelum mata membaca teks. Sumber ikon tunggal yang dipakai adalah Bootstrap Icons (https://icons.getbootstrap.com) atau Phosphor Icons varian *Regular*. Tidak ada pencampuran dua library ikon dalam satu halaman.

Aturan pemakaian ikon yang mengikat.

Ukuran ikon di menu sidebar dan tombol utama adalah 18 piksel. Ukuran ikon di toolbar tabel dan aksi baris adalah 16 piksel. Ukuran ikon empty state adalah 48 piksel.

Pemetaan ikon untuk modul kunci. Modul Data Nasabah memakai `bi-people`. Modul Pengajuan Pembiayaan memakai `bi-file-earmark-text`. Modul Input Nilai Kriteria memakai `bi-list-check`. Modul Hitung WP memakai `bi-calculator`. Modul Hasil & Ranking memakai `bi-bar-chart-line`. Modul Penetapan Keputusan memakai `bi-clipboard-check`. Modul Laporan memakai `bi-printer`. Modul Manajemen Pengguna memakai `bi-person-gear`. Modul Kriteria & Bobot memakai `bi-sliders`. Modul Periode Mingguan memakai `bi-calendar-week`. Modul Rekalibrasi Ambang memakai `bi-arrow-repeat`. Modul Audit Log memakai `bi-clock-history`.

Pemilihan ikon di atas mengikuti prinsip *recognizability over novelty*. Ikon yang familiar bagi pengguna komputer awam selalu dimenangkan di atas ikon yang lebih estetik tapi asing.

### 2.2 Mengurangi Beban Kognitif

Tabel padat finansial adalah momen paling melelahkan secara visual bagi petugas. Tiga kebijakan diterapkan untuk meringankannya.

Pertama, padding mengikat. Setiap sel tabel finansial memakai utility Tailwind `py-3 px-4` (12 piksel vertikal, 16 piksel horizontal). Tidak boleh lebih rapat. Permintaan "supaya muat lebih banyak baris" dijawab dengan paginasi atau scroll, bukan dengan mengecilkan padding.

Kedua, ringkasan dipisah dari detail. Setiap halaman tabel besar wajib didahului oleh ringkasan KPI di bagian atas. Petugas mendapat orientasi angka utama sebelum menyelam ke baris-baris detail.

Ketiga, batasan konten per layar. Maksimum lima jenis informasi berbeda dalam satu kartu. Bila lebih, pecah menjadi kartu terpisah atau dorong ke halaman detail. Padatnya konten bukan tanda kerja keras; padatnya konten adalah cacat desain.

### 2.3 Status Badge dan Alert yang Ramah Psikologis

Status keputusan adalah bagian paling sensitif dari sistem ini. Salah tafsir warna bisa berarti salah memberi atau menolak pembiayaan kepada nasabah. Karena itu, badge status mengikuti tiga aturan ketat.

Pertama, kontras lembut dan teks tegas. Badge memakai latar berwarna pucat dengan teks gelap pada keluarga warna yang sama, bukan latar pekat dengan teks putih. Latar pekat hanya digunakan ketika badge berdiri sendiri sebagai notifikasi utama, bukan dalam tabel padat.

Kedua, ikon kecil selalu menyertai teks. Status Diterima diiringi ikon `bi-check-circle`, Ditolak diiringi `bi-x-circle`, Diprioritaskan diiringi `bi-star-fill`, Menunggu diiringi `bi-hourglass-split`. Ini memenuhi syarat aksesibilitas WCAG 2.1 bahwa warna tidak boleh menjadi satu-satunya pembawa informasi.

Ketiga, kosakata baku Bahasa Indonesia. Tidak ada "Approved" atau "Pending" dalam tampilan. Kata "Diterima", "Ditolak", "Diprioritaskan", "Menunggu" sudah cukup dan dimengerti seluruh petugas.

---

## 3. ARSITEKTUR HYBRID SETUP — BOOTSTRAP 5 + TAILWIND CSS

Sistem ini memakai pendekatan *hybrid* yang sengaja dipilih: Bootstrap 5 sebagai fondasi struktur komponen (grid, form, modal, table, dropdown, navbar) dan Tailwind CSS sebagai lapisan *utility class* yang memoles komponen Bootstrap dengan presisi tinggi tanpa harus menulis CSS kustom panjang. Pendekatan hybrid ini telah menjadi pola umum sejak Tailwind 3 memperkenalkan mode JIT dan prefix opsional, dan terdokumentasi dengan baik pada laman resmi Tailwind (https://tailwindcss.com/docs) dan Bootstrap (https://getbootstrap.com/docs/5.3).

Aturan main hybrid setup ini wajib dipatuhi agar tidak terjadi tabrakan spesifisitas CSS yang membuat antarmuka rusak pada layar yang berbeda.

### 3.1 Pemasangan dan Konfigurasi

Pemasangan Tailwind dilakukan setelah Laravel 11 dan Bootstrap 5 sudah berfungsi normal. Perintah pemasangan mengikuti dokumentasi resmi Tailwind untuk Laravel:

```bash
npm install -D tailwindcss@latest postcss@latest autoprefixer@latest
npx tailwindcss init -p
```

Konfigurasi `tailwind.config.js` wajib disesuaikan sebagai berikut. Properti `prefix` dikosongkan karena utility Tailwind tidak bertabrakan dengan kelas Bootstrap (Bootstrap memakai pola `btn`, `card`, `form-control`, sedangkan Tailwind memakai pola atomik `p-4`, `flex`, `gap-x-2`). Properti `corePlugins.preflight` dimatikan untuk mencegah Tailwind menimpa reset CSS bawaan Bootstrap.

```js
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  corePlugins: {
    preflight: false, // PENTING — biarkan Bootstrap reboot.css yang aktif
  },
  theme: {
    extend: {
      colors: {
        primary: {
          50:  '#F2F8F5',
          100: '#E6F1EC',
          300: '#7FC2A8',
          500: '#2D8A6B',
          700: '#14543F',
          900: '#0E3B2E',
          950: '#082B22',
        },
        slate: {
          // tetap pakai default Tailwind slate; kompatibel dengan secondary
        },
      },
      fontFamily: {
        sans: ['Inter', 'Segoe UI', 'Roboto', 'system-ui', 'sans-serif'],
      },
      borderRadius: {
        md:  '0.375rem', // 6 px
        lg:  '0.5rem',   // 8 px
        xl:  '0.75rem',  // 12 px
      },
      boxShadow: {
        'elev-1': '0 1px 2px rgba(15, 30, 44, 0.04), 0 1px 3px rgba(15, 30, 44, 0.03)',
        'elev-2': '0 4px 12px rgba(15, 30, 44, 0.06), 0 2px 4px rgba(15, 30, 44, 0.04)',
        'elev-3': '0 10px 24px rgba(15, 30, 44, 0.08)',
      },
    },
  },
  plugins: [],
}
```

Pada `resources/css/app.css`, Bootstrap diimpor lebih dahulu, lalu Tailwind, lalu variabel kustom dan komponen CSS proyek. Urutan ini bersifat kritis.

```css
/* 1. Bootstrap dulu, agar reboot.css aktif lebih awal */
@import 'bootstrap/dist/css/bootstrap.min.css';

/* 2. Tailwind utilities (preflight sudah dimatikan di config) */
@tailwind components;
@tailwind utilities;

/* 3. Custom variables dan komponen proyek */
@import './variables.css';
@import './components.css';
```

### 3.2 Aturan Spesifisitas dan Pencegahan Konflik

Karena Bootstrap memakai *class selector* satu tingkat dengan beberapa override `!important` pada utility margin/padding (`mt-0`, `pe-3`), bisa terjadi situasi di mana utility Tailwind yang sama nama (Tailwind juga punya `mt-0`, `pe-3`) tidak menang. Praktik berikut menjamin tidak ada konflik.

Pertama, untuk *spacing* (margin, padding, gap), seluruhnya didelegasikan kepada Tailwind. Hindari kelas spacing Bootstrap (`mb-3`, `p-2`) di file Blade baru. Bagi kode lama yang sudah memakai kelas Bootstrap untuk spacing, biarkan saja sampai disentuh ulang dalam siklus refactor — tidak perlu migrasi paksa karena keduanya menghasilkan hasil yang setara. Kedua, untuk *layout flex/grid sederhana*, gunakan utility Tailwind (`flex`, `items-center`, `justify-between`, `gap-x-3`, `grid grid-cols-4`). Hindari pencampuran `d-flex` Bootstrap dan `flex` Tailwind pada elemen yang sama; pilih salah satu konsisten per blok. Ketiga, untuk *komponen kompleks* seperti modal, dropdown, dan navbar offcanvas, gunakan kelas Bootstrap karena membawa serta JavaScript-nya (`bootstrap.bundle.min.js`). Tailwind dipakai hanya untuk memoles tampilan dalam komponen tersebut.

Pola pemoles standar yang dipakai berulang pada kartu kontainer:

```html
<div class="card bg-white border border-slate-200 rounded-lg shadow-elev-1
            transition-all duration-200 hover:shadow-elev-2">
  <div class="card-body px-6 py-5">
    ...
  </div>
</div>
```

Pada potongan di atas, kelas Bootstrap `card` dan `card-body` membawa struktur layout dan padding default. Utility Tailwind menambah warna latar yang konsisten, radius modern 8 piksel, shadow halus, dan transisi 200 milidetik saat hover. Tidak ada konflik karena Tailwind hanya menambahkan properti yang tidak dipegang oleh Bootstrap.

### 3.3 Geometri Komponen Modern

Geometri lama yang kaku dan persegi diperbarui menjadi lebih melengkung modern untuk memberi kesan bersahabat dan mutakhir, tanpa kebablasan menjadi terlihat "mainan". Acuan resmi:

| Komponen | Radius lama | Radius baru | Utility Tailwind |
|---|---|---|---|
| Input, select, textarea | 4 px | 6 px | `rounded-md` |
| Tombol biasa | 4 px | 6 px | `rounded-md` |
| Tombol pill (filter chip) | 999 px | 999 px | `rounded-full` |
| Kartu standar | 6 px | 8 px | `rounded-lg` |
| Kartu KPI dasbor | 6 px | 12 px | `rounded-xl` |
| Modal | 8 px | 12 px | `rounded-xl` |
| Badge status | 999 px | 999 px | `rounded-full` |
| Avatar inisial | 999 px | 999 px | `rounded-full` |

Geometri di atas dipilih bukan karena tren, melainkan karena hasil pengamatan: radius 8–12 piksel adalah titik manis di mana antarmuka terasa modern namun masih cukup formal untuk konteks lembaga keuangan.

---

## 4. BLUEPRINT HALAMAN UTAMA DAN MICRO-INTERACTIONS

Bagian ini menulis ulang spesifikasi visual komponen kunci secara utuh, lengkap dengan utility class hybrid yang harus diterapkan.

### 4.1 Halaman Login (`/login`)

Tujuan halaman ini adalah otentikasi cepat dengan friksi minimum. Pengguna pertama kali harus merasa sedang masuk ke sistem yang serius dan tepercaya, bukan ke template gratisan.

Tata letak vertikal terpusat di tengah viewport. Latar halaman memakai `--color-bg-app` (off-white hangat `#F8FAFC`). Kartu login berada di tengah dengan lebar tetap 420 piksel pada desktop, full-width dengan padding lateral 16 piksel pada mobile.

Spesifikasi kartu login:

```html
<div class="min-h-screen flex items-center justify-center px-4
            bg-[#F8FAFC]">
  <div class="w-full max-w-[420px]">
    <div class="bg-white border border-slate-200 rounded-xl shadow-elev-2
                px-8 py-10">
      <!-- Logo + branding -->
      <div class="flex flex-col items-center mb-8">
        <div class="w-14 h-14 rounded-xl bg-primary-900 text-white
                    flex items-center justify-center mb-4
                    font-bold text-xl tracking-wider">SK</div>
        <h1 class="text-xl font-bold text-slate-900 text-center">
          SPK Pembiayaan KSPPS
        </h1>
        <p class="text-sm text-slate-500 text-center mt-1">
          Berkah Sakinah Almughni Girimarto
        </p>
      </div>
      <!-- Form -->
      <form method="POST" action="{{ route('login') }}"
            class="flex flex-col gap-y-4">
        @csrf
        <div>
          <label for="username"
                 class="block text-xs font-semibold text-slate-700
                        uppercase tracking-wide mb-1.5">Username</label>
          <input id="username" name="username" type="text" required
                 class="form-control rounded-md border-slate-300
                        px-3 py-2.5 text-sm">
        </div>
        <div>
          <label for="password"
                 class="block text-xs font-semibold text-slate-700
                        uppercase tracking-wide mb-1.5">Kata Sandi</label>
          <input id="password" name="password" type="password" required
                 class="form-control rounded-md border-slate-300
                        px-3 py-2.5 text-sm">
        </div>
        <label class="inline-flex items-center gap-x-2 text-sm text-slate-600">
          <input type="checkbox" name="remember"
                 class="form-check-input rounded">
          <span>Ingat saya</span>
        </label>
        <button type="submit"
                class="btn btn-primary w-full rounded-md py-2.5
                       font-semibold tracking-wide mt-2">
          Masuk
        </button>
      </form>
    </div>
    <p class="text-center text-xs text-slate-400 mt-6">
      © {{ date('Y') }} KSPPS Berkah Sakinah Almughni Girimarto
    </p>
  </div>
</div>
```

Catatan tambahan untuk halaman login. Tidak ada ilustrasi di samping kiri. Tidak ada gradient pada latar halaman. Validasi error untuk masing-masing input diletakkan persis di bawah input bersangkutan dengan warna `--color-status-reject-fg`. Kesalahan kredensial global muncul sebagai alert merah di atas kartu login, bukan di dalamnya. Toggle "lihat password" diaktifkan dengan ikon `bi-eye` line di kanan dalam input.

### 4.2 Dasbor Multi-role (`/dashboard`)

Dasbor adalah halaman pertama setelah login. Pengguna harus tahu dalam tiga detik: berapa pengajuan minggu ini, siapa diprioritaskan, dan apa aksi berikutnya.

Susunan dari atas ke bawah: sapaan singkat dengan nama pengguna dan peran, kemudian baris empat kartu KPI, kemudian tabel lima nasabah dengan ranking tertinggi pada periode aktif, lalu panel aksi cepat di sisi kiri dengan panel aktivitas terbaru di sisi kanan pada baris terakhir.

**Kartu KPI yang baru dan tidak monoton.** Kartu KPI memakai kombinasi tiga elemen visual sekaligus agar tidak terasa datar: garis aksen vertikal di sisi kiri, latar gradient mikro `--gradient-kpi-accent`, dan shadow halus `--elev-1`. Kartu tetap profesional namun terasa hidup.

```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <!-- KPI 1 — Total Pengajuan -->
  <div class="relative bg-white border border-slate-200 rounded-xl
              shadow-elev-1 overflow-hidden transition-all duration-200
              hover:shadow-elev-2">
    <span class="absolute left-0 top-0 bottom-0 w-1 bg-primary-900"></span>
    <div class="bg-gradient-to-b from-primary-50 to-white px-6 py-5">
      <div class="flex items-start justify-between mb-3">
        <p class="text-xs font-semibold text-slate-500 uppercase
                  tracking-wide">Total Pengajuan</p>
        <i class="bi bi-file-earmark-text text-slate-400 text-base"></i>
      </div>
      <p class="text-4xl font-bold text-slate-900 tabular-nums
                leading-none">20</p>
      <p class="text-xs text-slate-500 mt-2">Periode #2024-W14</p>
    </div>
  </div>

  <!-- KPI 2 — Diterima (varian sukses) -->
  <div class="relative bg-white border border-slate-200 rounded-xl
              shadow-elev-1 overflow-hidden transition-all duration-200
              hover:shadow-elev-2">
    <span class="absolute left-0 top-0 bottom-0 w-1 bg-green-700"></span>
    <div class="bg-gradient-to-b from-primary-50 to-white px-6 py-5">
      <div class="flex items-start justify-between mb-3">
        <p class="text-xs font-semibold text-slate-500 uppercase
                  tracking-wide">Diterima</p>
        <i class="bi bi-check-circle text-slate-400 text-base"></i>
      </div>
      <p class="text-4xl font-bold text-slate-900 tabular-nums
                leading-none">14</p>
      <p class="text-xs text-slate-500 mt-2">70% dari total</p>
    </div>
  </div>

  <!-- KPI 3 — Ditolak -->
  <div class="relative bg-white border border-slate-200 rounded-xl
              shadow-elev-1 overflow-hidden transition-all duration-200
              hover:shadow-elev-2">
    <span class="absolute left-0 top-0 bottom-0 w-1 bg-red-700"></span>
    <div class="bg-gradient-to-b from-primary-50 to-white px-6 py-5">
      <div class="flex items-start justify-between mb-3">
        <p class="text-xs font-semibold text-slate-500 uppercase
                  tracking-wide">Ditolak</p>
        <i class="bi bi-x-circle text-slate-400 text-base"></i>
      </div>
      <p class="text-4xl font-bold text-slate-900 tabular-nums
                leading-none">6</p>
      <p class="text-xs text-slate-500 mt-2">30% dari total</p>
    </div>
  </div>

  <!-- KPI 4 — Diprioritaskan -->
  <div class="relative bg-white border border-slate-200 rounded-xl
              shadow-elev-1 overflow-hidden transition-all duration-200
              hover:shadow-elev-2">
    <span class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-700"></span>
    <div class="bg-gradient-to-b from-primary-50 to-white px-6 py-5">
      <div class="flex items-start justify-between mb-3">
        <p class="text-xs font-semibold text-slate-500 uppercase
                  tracking-wide">Diprioritaskan</p>
        <i class="bi bi-star-fill text-slate-400 text-base"></i>
      </div>
      <p class="text-4xl font-bold text-slate-900 tabular-nums
                leading-none">5</p>
      <p class="text-xs text-slate-500 mt-2">Top 5 V_i tertinggi</p>
    </div>
  </div>
</div>
```

Untuk peran *Administrator*, isi KPI baris atas diganti menjadi: Total Pengguna Aktif, Periode Aktif, Akurasi LOOCV Terkini, Perubahan Bobot 7 Hari Terakhir. Tabel lima nasabah tetap ditampilkan kepada admin sebagai pemantauan baca-saja.

**Tabel Top-5.** Tabel ini menampilkan ranking lima nasabah dengan vektor V_i tertinggi. Kolomnya: Ranking, Nama Nasabah, Vektor S, Vektor V, Status. Kolom Ranking menampilkan angka di dalam *numeric chip* berukuran 28 piksel dengan latar `--color-primary-100` dan teks `--color-primary-900` — bukan emoji medali. Kolom Vektor S dan V menggunakan `tabular-nums` rata kanan. Kolom Status memakai komponen `<x-status-badge>` sesuai §5.

Footer tabel memuat satu link tunggal "Lihat semua nasabah →" rata kanan dengan varian ghost.

### 4.3 Form Input Kriteria Pembiayaan (`/pengajuan/create`)

Form ini paling sering diisi petugas. Wajib *forgiving*, terbaca cepat, dan tidak menimbulkan keraguan saat memasukkan angka. Layout dibagi menjadi dua kartu seksi vertikal: identitas nasabah di atas, parameter kriteria di bawah.

Pola kunci yang membedakan dari versi lama adalah penanda badge [B] dan [C] yang diletakkan **di sisi kiri label**, langsung mendahului nama kriteria, sehingga petugas tahu sifat kriteria sebelum membaca penjelasannya. Badge [B] berwarna hijau lembut menandakan *benefit* (lebih besar lebih baik); badge [C] berwarna merah lembut menandakan *cost* (lebih kecil lebih baik). Kontras hijau-merah ini sudah menjadi konvensi finansial yang dipahami luas, sekaligus aman bagi pengguna buta warna parsial karena tetap disertai huruf B/C sebagai pembeda non-warna.

```html
<form method="POST" action="{{ route('pengajuan.store') }}"
      class="max-w-4xl mx-auto flex flex-col gap-y-6">
  @csrf

  <!-- Header halaman -->
  <div class="mb-2">
    <h1 class="text-2xl font-bold text-slate-900">
      Pengajuan Pembiayaan Baru
    </h1>
    <p class="text-sm text-slate-500 mt-1">
      <span class="text-slate-400">Pengajuan</span>
      <i class="bi bi-chevron-right text-[10px] mx-1 text-slate-300"></i>
      Tambah pengajuan
    </p>
  </div>

  <!-- Seksi 1 — Identitas Nasabah -->
  <section class="bg-white border border-slate-200 rounded-lg shadow-elev-1
                  overflow-hidden">
    <header class="px-6 py-4 border-b border-slate-200">
      <h2 class="text-lg font-semibold text-slate-900">
        Seksi 1 — Identitas Nasabah
      </h2>
      <p class="text-xs text-slate-500 mt-0.5">
        Isi data dasar pemohon pembiayaan.
      </p>
    </header>
    <div class="px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
      <div>
        <label for="nama_nasabah"
               class="block text-xs font-semibold text-slate-700
                      uppercase tracking-wide mb-1.5">
          Nama Nasabah <span class="text-red-700">*</span>
        </label>
        <input id="nama_nasabah" name="nama_nasabah" type="text" required
               class="form-control rounded-md border-slate-300 px-3 py-2.5">
      </div>
      <div>
        <label for="no_anggota"
               class="block text-xs font-semibold text-slate-700
                      uppercase tracking-wide mb-1.5">
          No. Anggota <span class="text-red-700">*</span>
        </label>
        <input id="no_anggota" name="no_anggota" type="text" required
               class="form-control rounded-md border-slate-300 px-3 py-2.5">
      </div>
      <div>
        <label for="id_periode"
               class="block text-xs font-semibold text-slate-700
                      uppercase tracking-wide mb-1.5">
          Periode Mingguan <span class="text-red-700">*</span>
        </label>
        <select id="id_periode" name="id_periode" required
                class="form-select rounded-md border-slate-300 px-3 py-2.5">
          @foreach($periodes as $p)
            <option value="{{ $p->id }}">{{ $p->kode_periode }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="tgl_pengajuan"
               class="block text-xs font-semibold text-slate-700
                      uppercase tracking-wide mb-1.5">
          Tanggal Pengajuan <span class="text-red-700">*</span>
        </label>
        <input id="tgl_pengajuan" name="tgl_pengajuan" type="date" required
               class="form-control rounded-md border-slate-300 px-3 py-2.5">
      </div>
    </div>
  </section>

  <!-- Seksi 2 — Parameter Kriteria WP -->
  <section class="bg-white border border-slate-200 rounded-lg shadow-elev-1
                  overflow-hidden">
    <header class="px-6 py-4 border-b border-slate-200">
      <h2 class="text-lg font-semibold text-slate-900">
        Seksi 2 — Parameter Kriteria Weighted Product
      </h2>
      <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">
        Lima kriteria penilaian.
        <span class="inline-flex items-center gap-x-1.5 ml-1">
          <span class="badge-criteria badge-criteria-benefit">B</span>
          <span class="text-slate-600">= benefit, lebih besar lebih baik.</span>
        </span>
        <span class="inline-flex items-center gap-x-1.5 ml-2">
          <span class="badge-criteria badge-criteria-cost">C</span>
          <span class="text-slate-600">= cost, lebih kecil lebih baik.</span>
        </span>
      </p>
    </header>
    <div class="px-6 py-6 flex flex-col gap-y-5">

      <!-- C1 — Laba Usaha (Benefit) -->
      <div>
        <label for="c1" class="flex items-center text-sm font-semibold
                               text-slate-800 mb-1.5">
          <span class="badge-criteria badge-criteria-benefit mr-2">B</span>
          C1 — Laba Usaha (Rp/bulan)
          <span class="text-red-700 ml-1">*</span>
        </label>
        <input id="c1" name="c1_laba_usaha" type="text" inputmode="numeric"
               required data-mask="rupiah"
               class="form-control rounded-md border-slate-300 px-3 py-2.5
                      tabular-nums text-end">
        <p class="text-xs text-slate-500 mt-1.5">
          Surplus bersih dari hasil usaha nasabah per bulan.
        </p>
      </div>

      <!-- C2 — Pendapatan Bersih (Benefit) -->
      <div>
        <label for="c2" class="flex items-center text-sm font-semibold
                               text-slate-800 mb-1.5">
          <span class="badge-criteria badge-criteria-benefit mr-2">B</span>
          C2 — Pendapatan Bersih (Rp/bulan)
          <span class="text-red-700 ml-1">*</span>
        </label>
        <input id="c2" name="c2_pendapatan_bersih" type="text"
               inputmode="numeric" required data-mask="rupiah"
               class="form-control rounded-md border-slate-300 px-3 py-2.5
                      tabular-nums text-end">
        <p class="text-xs text-slate-500 mt-1.5">
          Penghasilan pribadi setelah dikurangi kebutuhan pokok.
        </p>
      </div>

      <!-- C3 — Nilai Agunan (Benefit, skala) -->
      <div>
        <label for="c3" class="flex items-center text-sm font-semibold
                               text-slate-800 mb-1.5">
          <span class="badge-criteria badge-criteria-benefit mr-2">B</span>
          C3 — Nilai Agunan
          <span class="text-red-700 ml-1">*</span>
        </label>
        <select id="c3" name="c3_agunan" required
                class="form-select rounded-md border-slate-300 px-3 py-2.5">
          <option value="">Pilih skala agunan…</option>
          <option value="1">1 — Tanpa Agunan</option>
          <option value="2">2 — BPKB Sepeda Motor</option>
          <option value="3">3 — BPKB Mobil</option>
          <option value="4">4 — Sertifikat Tanah / Bangunan</option>
        </select>
        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
          Skala 1 (tanpa agunan) sampai 4 (sertifikat tanah/bangunan).
        </p>
      </div>

      <!-- C4 — Besar Pembiayaan (Cost) -->
      <div>
        <label for="c4" class="flex items-center text-sm font-semibold
                               text-slate-800 mb-1.5">
          <span class="badge-criteria badge-criteria-cost mr-2">C</span>
          C4 — Besar Pembiayaan (Rp)
          <span class="text-red-700 ml-1">*</span>
        </label>
        <input id="c4" name="c4_besar_pembiayaan" type="text"
               inputmode="numeric" required data-mask="rupiah"
               class="form-control rounded-md border-slate-300 px-3 py-2.5
                      tabular-nums text-end">
        <p class="text-xs text-slate-500 mt-1.5">
          Nilai pembiayaan yang diajukan nasabah.
        </p>
      </div>

      <!-- C5 — Jangka Waktu (Cost) -->
      <div>
        <label for="c5" class="flex items-center text-sm font-semibold
                               text-slate-800 mb-1.5">
          <span class="badge-criteria badge-criteria-cost mr-2">C</span>
          C5 — Jangka Waktu (Bulan)
          <span class="text-red-700 ml-1">*</span>
        </label>
        <input id="c5" name="c5_jangka_waktu" type="number" min="1" required
               class="form-control rounded-md border-slate-300 px-3 py-2.5
                      tabular-nums text-end max-w-[200px]">
        <p class="text-xs text-slate-500 mt-1.5">
          Tenor pembiayaan dalam satuan bulan.
        </p>
      </div>

    </div>
  </section>

  <!-- Action bar sticky -->
  <div class="sticky bottom-0 bg-white/95 backdrop-blur-sm
              border-t border-slate-200 -mx-6 px-6 py-4
              flex justify-end gap-x-3 mt-2">
    <a href="{{ route('pengajuan.index') }}"
       class="btn btn-outline-secondary rounded-md px-5 py-2.5
              font-semibold">Batal</a>
    <button type="submit"
            class="btn btn-primary rounded-md px-5 py-2.5 font-semibold
                   shadow-elev-1 hover:shadow-elev-2 transition-shadow">
      <i class="bi bi-calculator me-1"></i>
      Simpan & Hitung
    </button>
  </div>
</form>
```

Styling badge kriteria didefinisikan sekali pada `resources/css/components.css`:

```css
.badge-criteria {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 22px;
  height: 22px;
  border-radius: 4px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0;
  flex-shrink: 0;
}
.badge-criteria-benefit {
  background: var(--color-status-accept-bg);
  color: var(--color-status-accept-fg);
  border: 1px solid var(--color-status-accept-bd);
}
.badge-criteria-cost {
  background: var(--color-status-reject-bg);
  color: var(--color-status-reject-fg);
  border: 1px solid var(--color-status-reject-bd);
}
```

Input rupiah memakai mask thousand-separator. Pengguna mengetik angka mentah, sistem menampilkan format Indonesia. Saat submit, nilai dikirim sebagai angka tanpa pemisah. Library yang direkomendasikan adalah IMask.js (https://imask.js.org, ringan ±10 KB) atau implementasi vanilla sederhana yang membaca atribut `data-mask="rupiah"`.

### 4.4 Sidebar dan Topbar (Master Layout)

Sidebar gelap solid menggunakan `--color-secondary-900` dengan lebar tetap 248 piksel pada desktop dan menjadi off-canvas pada viewport di bawah 992 piksel. Logo monogram "SK" 36×36 piksel berlatar `--color-primary-900` ditempatkan di kepala sidebar.

Pengelompokan menu memakai label uppercase 11 piksel dengan warna `--color-secondary-400`. Penanda item aktif bukan blok latar penuh, melainkan garis vertikal solid 3 piksel di tepi kiri item dengan warna `--color-primary-500`, ditambah latar item `rgba(255,255,255,0.04)` dan teks `#FFFFFF`. Item hover memakai latar `rgba(255,255,255,0.06)` tanpa garis indikator. Pilihan ini memberi kesan rapi dan tidak mengganggu kontur sidebar.

Topbar berukuran 56 piksel tinggi, latar `--color-bg-surface` dengan `border-bottom: 1px solid var(--color-border)`, posisi sticky di atas konten. Susunan dari kiri ke kanan adalah tombol burger (hanya mobile), judul halaman aktif yang ditarik otomatis dari `@section('page_title')`, spacer fleksibel, penunjuk periode aktif berupa pill berisi ikon kalender dan kode periode (`Periode #2024-W14`), bel notifikasi, lalu dropdown profil dengan avatar inisial berlatar `--color-primary-100`.

### 4.5 Tabel Data Finansial

Tabel adalah tempat petugas menghabiskan paling banyak waktu. Spesifikasi mengikat berlaku.

Kelas dasar memakai kombinasi `table table-hover align-middle` Bootstrap ditambah utility Tailwind untuk padding dan tipografi. Tidak ada `table-striped` karena zebra bertabrakan dengan badge status. Border tabel hanya `border-bottom: 1px solid var(--color-border)` pada setiap baris, tidak ada border vertikal antar kolom. Header tabel berlatar `--color-bg-subtle`, font uppercase 12 piksel weight 600 dengan letter-spacing 0.04em, tinggi 44 piksel, padding horizontal 16 piksel. Sticky header wajib aktif bila baris lebih dari sepuluh, dengan `position: sticky; top: 56px; z-index: 1` agar tepat menyatu di bawah Topbar.

Sel tubuh memakai padding 12 piksel vertikal dan 16 piksel horizontal (`py-3 px-4`), `vertical-align: middle`. Hover baris memberi latar `#F1F5F9` dengan transisi 120 milidetik.

Seluruh kolom nominal rupiah, S_i, V_i, ranking, dan persentase wajib `text-align: right` dan memakai `tabular-nums`. Kolom nama nasabah memakai `white-space: nowrap; text-overflow: ellipsis; max-width: 220px;`. Aksi baris (Detail, Edit, Hapus) di kolom paling kanan dengan lebar tetap 120 piksel berisi ikon line 16 piksel dalam tombol ghost 32×32 piksel dengan tooltip.

Format rupiah menggunakan helper Laravel `Number::currency($v, 'IDR', 'id', precision: 0)` sehingga muncul sebagai `Rp 6.100.000` tanpa desimal. Format S_i menampilkan empat angka di belakang koma (misal `269.3142`); format V_i menampilkan lima angka di belakang koma (misal `0.03987`) atau persentase satu desimal (`3,99%`) — pilih satu konvensi konsisten per tabel.

---

## 5. MICRO-INTERACTIONS DAN STATE HANDLING

### 5.1 Loading State

Tombol primary saat menjalankan komputasi (misalnya "Hitung WP" atau "Simpan & Hitung") memakai pola berikut: tombol dinonaktifkan, ikon awal diganti dengan spinner inline 14 piksel, dan label berubah menjadi gerundium ("Memproses…", "Menyimpan…"). Spinner tidak memakai `.spinner-border` Bootstrap default karena terlalu tebal.

```css
.spinner-inline {
  width: 14px; height: 14px; border-radius: 50%;
  border: 2px solid rgba(255,255,255,0.45);
  border-top-color: #FFFFFF;
  animation: spin 0.6s linear infinite;
  display: inline-block; margin-right: 8px; vertical-align: -2px;
}
@keyframes spin { to { transform: rotate(360deg); } }
```

Untuk halaman list yang memuat data via AJAX, gunakan skeleton row pada `<tbody>` selama menunggu — bukan overlay penuh halaman. Skeleton row memakai shimmer halus 1.4 detik dengan tiga warna keluarga abu-abu (`#F1F5F9 → #F8FAFC → #F1F5F9`).

### 5.2 Empty State

Empty state adalah momen kepercayaan: pengguna yang membuka halaman dengan tabel kosong sering mengira sistem rusak. Karena itu setiap tabel kosong wajib menampilkan empty state dengan ikon line 48 piksel, headline `text-h3`, body 1–2 kalimat, dan satu CTA primary yang mengarah ke aksi natural berikutnya.

```html
<div class="flex flex-col items-center justify-center text-center
            px-8 py-16">
  <i class="bi bi-inbox text-5xl text-slate-300 mb-4"></i>
  <h3 class="text-base font-semibold text-slate-800 mb-2">
    Belum ada pengajuan pada periode ini
  </h3>
  <p class="text-sm text-slate-500 max-w-md mb-6 leading-relaxed">
    Periode #2024-W14 (01–07 April 2024) masih kosong.
    Tambahkan pengajuan pertama untuk memulai perhitungan.
  </p>
  <a href="{{ route('pengajuan.create') }}"
     class="btn btn-primary rounded-md px-5 py-2.5 font-semibold">
    <i class="bi bi-plus-lg me-1"></i> Tambah Pengajuan Baru
  </a>
</div>
```

### 5.3 Flash Alert

Alert ditempatkan di atas konten utama, tepat di bawah Topbar, dengan lebar mengikuti container konten. Setiap alert memakai pola: latar lembut, teks pekat warna senada, garis aksen kiri 3 piksel berwarna penegas, dan ikon line 18 piksel di kiri teks.

| Tipe | Latar | Teks | Aksen kiri | Ikon |
|---|---|---|---|---|
| success | `--color-status-accept-bg` | `--color-status-accept-fg` | 3 px solid `--color-status-accept-fg` | `bi-check-circle` |
| danger | `--color-status-reject-bg` | `--color-status-reject-fg` | 3 px solid `--color-status-reject-fg` | `bi-exclamation-octagon` |
| warning | `--color-status-pending-bg` | `--color-status-pending-fg` | 3 px solid `--color-status-pending-fg` | `bi-exclamation-triangle` |
| info | `--color-status-priority-bg` | `--color-status-priority-fg` | 3 px solid `--color-status-priority-fg` | `bi-info-circle` |

Auto-dismiss 5 detik berlaku untuk `success` dan `info`. Tipe `danger` dan `warning` tidak auto-dismiss sehingga pengguna sadar dan menutup manual. Animasi munculnya `opacity 0 → 1` dalam 200 milidetik, animasi keluarnya `opacity 1 → 0` dalam 300 milidetik. Tidak ada slide horizontal atau bounce.

### 5.4 Konfirmasi Destruktif

Aksi menghapus, menolak permanen, atau merekalibrasi ambang θ wajib melalui modal konfirmasi — bukan `window.confirm()` bawaan peramban. Modal memakai lebar 480 piksel, padding 24 piksel, radius 12 piksel, shadow `--elev-3`, backdrop `rgba(15, 30, 44, 0.45)`. Tombol Batal selalu di kiri, tombol konfirmasi selalu di kanan. Tombol konfirmasi memakai varian primary untuk aksi netral atau secondary dengan teks merah `--color-status-reject-fg` untuk aksi destruktif.

---

## 6. AKSESIBILITAS DAN RESPONSIVITAS

Standar aksesibilitas merujuk WCAG 2.1 level AA sebagaimana didokumentasikan oleh W3C (https://www.w3.org/TR/WCAG21). Kontras teks terhadap latar minimum 4.5:1 untuk body dan 3:1 untuk teks besar. Setiap input wajib memiliki `<label for="...">` eksplisit — placeholder tidak diperbolehkan menjadi pengganti label. Setiap tombol berisi hanya ikon wajib disertai `aria-label`. Fokus keyboard wajib terlihat melalui `:focus-visible` dengan outline 3 piksel berwarna `--color-focus-ring`. Tab order mengikuti urutan visual; `tabindex` lebih dari 0 dilarang. Status warna tidak boleh menjadi satu-satunya pembawa informasi, sehingga badge status selalu memuat teks dan ikon, bukan hanya warna dot.

Breakpoint mengikuti Bootstrap 5 default: `sm` 576 piksel, `md` 768 piksel, `lg` 992 piksel, `xl` 1200 piksel, `xxl` 1400 piksel. Sistem dioptimasi untuk `lg` dan `xl` karena petugas KSPPS bekerja di laptop. Mobile didukung sebatas fungsional (input pengajuan dadakan via ponsel) tanpa dijadikan target estetika utama.

---

## 7. KOMPONEN BLADE WAJIB DISEDIAKAN

Komponen Blade reusable berikut wajib ada di `resources/views/components/`. Setiap komponen menerima props yang masuk akal dan menyertakan contoh pemakaian dalam komentar Blade di file komponennya.

| Komponen | Path | Fungsi |
|---|---|---|
| `<x-app-layout>` | `app-layout.blade.php` | Layout master (sidebar + topbar + slot konten) |
| `<x-auth-layout>` | `auth-layout.blade.php` | Layout halaman login (terpusat, tanpa chrome) |
| `<x-sidebar>` | `sidebar.blade.php` | Sidebar dengan grouping menu berbasis peran |
| `<x-topbar>` | `topbar.blade.php` | Topbar dengan penunjuk periode aktif |
| `<x-kpi-card>` | `kpi-card.blade.php` | Kartu KPI dengan garis aksen kiri dan gradient mikro |
| `<x-status-badge>` | `status-badge.blade.php` | Badge pill status dengan ikon |
| `<x-criteria-badge>` | `criteria-badge.blade.php` | Badge [B]/[C] untuk form kriteria |
| `<x-data-table>` | `data-table.blade.php` | Wrapper tabel finansial dengan sticky header |
| `<x-empty-state>` | `empty-state.blade.php` | Empty state generik |
| `<x-alert>` | `alert.blade.php` | Flash alert dengan auto-dismiss |
| `<x-confirm-modal>` | `confirm-modal.blade.php` | Modal konfirmasi destruktif |
| `<x-section-header>` | `section-header.blade.php` | Header seksi form dengan judul dan meta |
| `<x-form-field>` | `form-field.blade.php` | Wrapper input dengan label, helper, error |

---

## 8. COMPONENT CHEAT SHEET — UTILITY HYBRID YANG WAJIB DITEMPEL

Bagian ringkasan ini dimaksudkan untuk ditempel di samping monitor developer dan dipakai sebagai rujukan cepat agar konsistensi visual terjaga di seluruh halaman tanpa perlu membuka ulang dokumen panjang. Pola di bawah adalah komposisi utility Tailwind dipadu kelas Bootstrap yang sudah teruji tidak bertabrakan.

**Kartu standar (container konten):**
`bg-white border border-slate-200 rounded-lg shadow-elev-1 px-6 py-5`

**Kartu KPI (dasbor):**
`relative bg-white border border-slate-200 rounded-xl shadow-elev-1 overflow-hidden transition-all duration-200 hover:shadow-elev-2`
Tambahkan `<span class="absolute left-0 top-0 bottom-0 w-1 bg-primary-900"></span>` di dalamnya untuk garis aksen.

**Tombol primary utama:**
`btn btn-primary rounded-md px-5 py-2.5 font-semibold shadow-elev-1 hover:shadow-elev-2 transition-shadow duration-200`

**Tombol secondary:**
`btn btn-outline-secondary rounded-md px-5 py-2.5 font-semibold`

**Tombol ghost (toolbar tabel):**
`btn btn-link text-slate-600 rounded-md px-3 py-1.5 no-underline hover:bg-slate-100`

**Input form:**
`form-control rounded-md border-slate-300 px-3 py-2.5 text-sm`

**Label form:**
`block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5`

**Helper text:**
`text-xs text-slate-500 mt-1.5 leading-relaxed`

**Error text:**
`text-xs text-red-700 mt-1.5 flex items-center gap-x-1`

**Sel tabel angka:**
`text-end tabular-nums font-medium text-slate-800 px-4 py-3`

**Header tabel:**
`bg-slate-50 text-xs font-semibold text-slate-600 uppercase tracking-wide px-4 py-3`

**Badge status diterima:**
`inline-flex items-center gap-x-1 rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800 border border-green-200`

**Badge status ditolak:**
`inline-flex items-center gap-x-1 rounded-full px-2.5 py-0.5 text-xs font-semibold bg-red-100 text-red-800 border border-red-200`

**Badge status diprioritaskan:**
`inline-flex items-center gap-x-1 rounded-full px-2.5 py-0.5 text-xs font-semibold bg-indigo-100 text-indigo-800 border border-indigo-200`

**Badge kriteria [B]:** kelas custom `badge-criteria badge-criteria-benefit` (didefinisikan di `components.css`).

**Badge kriteria [C]:** kelas custom `badge-criteria badge-criteria-cost`.

**Grid KPI dasbor (responsif):**
`grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4`

**Action bar sticky di bawah form:**
`sticky bottom-0 bg-white/95 backdrop-blur-sm border-t border-slate-200 -mx-6 px-6 py-4 flex justify-end gap-x-3`

---

## 9. DICTUMS — LARANGAN MENGIKAT

Setiap pull request yang melanggar daftar berikut wajib direvisi.

Pertama, tidak ada shadow tebal melebihi `--elev-3`. Kedua, tidak ada gradient di luar dua gradient mikro yang sudah ditetapkan di §1.3. Ketiga, tidak ada glassmorphism atau `backdrop-filter: blur` melebihi 8 piksel kecuali pada action bar sticky (yang sudah ditetapkan). Keempat, tidak ada hero ilustrasi 3D, mockup laptop bercahaya, atau ilustrasi orang generik. Kelima, tidak ada ikon dalam lingkaran berwarna penuh berukuran lebih dari 32 piksel di kartu KPI. Keenam, tidak ada emoji pada UI produksi; pakai ikon SVG line. Ketujuh, tidak ada `border-radius` lebih dari 12 piksel untuk komponen persegi panjang (kecuali pill 999 piksel). Kedelapan, tidak ada animasi loop tak berhenti (`animation: bounce 1s infinite`) pada CTA. Kesembilan, tidak ada copy hero bergaya AI klise ("Empowering Your Financial Journey ✨"); gunakan Bahasa Indonesia baku dan lugas. Kesepuluh, whitespace tidak boleh dikorbankan demi memuat lebih banyak konten — padding kartu minimum 20 piksel dan padding sel tabel minimum 12 piksel vertikal.

Uji mata cepat sebelum merge: bila tangkapan layar antarmuka ditempel pada slide presentasi fintech serius, ia harus terlihat wajar. Bila ia terlihat seperti landing page template marketplace, tolak.

---

**Akhir DESIGN.md.** Setiap deviasi wajib direview oleh penanggung jawab desain sebelum digabung ke cabang utama. Konsistensi visual adalah bagian dari kualitas produk dan kepercayaan pengguna terhadap sistem.