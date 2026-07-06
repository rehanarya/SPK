<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\LoocvController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\SensitivitasController;
use App\Http\Controllers\Admin\ThresholdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\KeputusanController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web — SPK Pembiayaan KSPPS
| Struktur navigasi sesuai §8 RULES.md (Gambar 3.5 dokumen)
|--------------------------------------------------------------------------
*/

// ── Publik ────────────────────────────────────────────────────────────────
Route::get('/', fn () => redirect()->route('login'))->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// ── Terautentikasi (semua peran) ──────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil (kedua peran)
    Route::get('/profil',    [ProfilController::class, 'show'])->name('profil.show');
    Route::put('/profil',    [ProfilController::class, 'update'])->name('profil.update');

    // ── Area Petugas Pembiayaan ───────────────────────────────────────────
    Route::middleware('role:petugas,admin')->group(function () {

        // Manajemen Nasabah
        Route::resource('nasabah', NasabahController::class)->parameters([
            'nasabah' => 'nasabah:id_nasabah',
        ]);

        // Input Pengajuan (create form + store = lewat PenilaianController)
        Route::get('/pengajuan',        [PenilaianController::class, 'create'])->name('pengajuan.index');
        Route::get('/pengajuan/create', [PenilaianController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan',       [PenilaianController::class, 'store'])->name('pengajuan.store');
        Route::get('/pengajuan/{pengajuan}/edit',  [PenilaianController::class, 'edit'])
            ->name('pengajuan.edit')->whereNumber('pengajuan');
        Route::put('/pengajuan/{pengajuan}',       [PenilaianController::class, 'update'])
            ->name('pengajuan.update')->whereNumber('pengajuan');
        Route::get('/pengajuan/{pengajuan}/cetak', [PenilaianController::class, 'cetak'])
            ->name('pengajuan.cetak')->whereNumber('pengajuan');

        // Perhitungan WP per periode aktif
        Route::get('/perhitungan/wp',   [PenilaianController::class, 'indexWP'])->name('perhitungan.wp');
        Route::post('/perhitungan/wp',  [PenilaianController::class, 'hitungWP'])->name('perhitungan.wp.hitung');

        // Hasil & Ranking
        Route::get('/hasil',             [HasilController::class, 'index'])->name('hasil.index');
        Route::get('/hasil/{hasil}',     [HasilController::class, 'show'])
            ->name('hasil.show')
            ->where('hasil', '[0-9]+');

        // Penetapan Keputusan & Laporan
        // (Edit pengajuan — termasuk realisasi & ttd Manager — memakai
        //  pengajuan.edit / pengajuan.update untuk SEMUA status keputusan)
        Route::get('/keputusan',                        [KeputusanController::class, 'index'])->name('keputusan.index');
        Route::post('/keputusan/{hasil}',               [KeputusanController::class, 'store'])->name('keputusan.store');
    });

    // ── Area Administrator ────────────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        // Manajemen Pengguna
        Route::resource('pengguna', PenggunaController::class)->parameters([
            'pengguna' => 'pengguna:id_pengguna',
        ]);

        // Manajemen Kriteria & Bobot
        Route::get('/kriteria',              [KriteriaController::class, 'index'])->name('kriteria.index');
        Route::get('/kriteria/{kriteria}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
        Route::put('/kriteria/{kriteria}',   [KriteriaController::class, 'update'])->name('kriteria.update');

        // Manajemen Periode Mingguan
        Route::resource('periode', PeriodeController::class)->only(['index', 'create', 'store']);
        Route::patch('/periode/{periode}/toggle', [PeriodeController::class, 'toggleStatus'])->name('periode.toggle');

        // Audit Log
        Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');

        // Rekalibrasi Ambang θ (§5.3)
        Route::get('/threshold',          [ThresholdController::class, 'index'])->name('threshold.index');
        Route::post('/threshold/preview', [ThresholdController::class, 'preview'])->name('threshold.preview');
        Route::post('/threshold/apply',   [ThresholdController::class, 'apply'])->name('threshold.apply');
        Route::post('/threshold/manual',  [ThresholdController::class, 'updateAmbangManual'])->name('threshold.manual');

        // Analisis Sensitivitas (§7.1.3)
        Route::get('/sensitivitas', [SensitivitasController::class, 'index'])->name('sensitivitas.index');

        // Uji Akurasi LOOCV (§7.1.2)
        Route::get('/loocv', [LoocvController::class, 'index'])->name('loocv.index');
    });
});
