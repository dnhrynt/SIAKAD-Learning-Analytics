<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\RombonganBelajarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\GuruMapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\RombelSiswaController;
use App\Http\Controllers\KenaikanKelasController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\TujuanPembelajaranController;
use App\Http\Controllers\JenisPenilaianController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\DashboardAnalitikController;
use App\Http\Controllers\RekapNilaiController;

use Illuminate\Support\Facades\Artisan;


Route::get('/run-migrate', function () {
    Artisan::call('migrate --seed');
    return 'Migration & Seeder berhasil dijalankan';
});


Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/login', function () {return view('auth.login');})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password',function(){return view('auth.forgot-password');})->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/reset-password', function () {return view('auth.reset-password');})->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('index');
        Route::get('/create', [GuruController::class, 'create'])->name('create');
        Route::post('/store', [GuruController::class, 'store'])->name('store');
        Route::get('/profil', [GuruController::class, 'show'])->name('show');
        Route::get('/profil/edit', [GuruController::class, 'edit'])->name('edit');
        Route::put('/profil', [GuruController::class, 'update'])->name('update');
    });

    Route::prefix('guru-mapel')->name('guru-mapel.')->group(function(){
        Route::get('/', [GuruMapelController::class, 'index'])->name('index');
        Route::get('/create', [GuruMapelController::class, 'create'])->name('create');
        Route::post('/store', [GuruMapelController::class, 'store'])->name('store');
        Route::get('/{guruMapel}/edit', [GuruMapelController::class, 'edit'])->name('edit');
        Route::put('/{guruMapel}/update', [GuruMapelController::class, 'update'])->name('update');
        Route::delete('/{guruMapel}/delete', [GuruMapelController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jadwal')->name('jadwal.')->group(function(){
        Route::get('/', [JadwalController::class, 'index'])->name('index');
        Route::get('/mengajar', [JadwalController::class, 'mengajar'])->name('mengajar');
        Route::get('/create', [JadwalController::class, 'create'])->name('create');
        Route::post('/', [JadwalController::class, 'store'])->name('store');
        Route::get('/{jadwal}/edit', [JadwalController::class, 'edit'])->name('edit');
        Route::put('/{jadwal}', [JadwalController::class, 'update'])->name('update');
    });

    Route::prefix('siswa')->name('siswa.')->group(function() {
        Route::get('/', [SiswaController::class, 'index'])->name('index');
        Route::get('/create', [SiswaController::class, 'create'])->name('create');
        Route::post('/', [SiswaController::class, 'store'])->name('store');
        Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('edit');
        Route::put('/{siswa}', [SiswaController::class, 'update'])->name('update');
    });

    Route::prefix('rombel-siswa')->name('rombel-siswa.')->group(function(){
        Route::put('/{rombelSiswa}/status', [RombelSiswaController::class, 'updateStatus'])->name('update-status');
    });

    Route::prefix('kenaikan-kelas')->name('kenaikan-kelas.')->group(function(){
        Route::get('/', [KenaikanKelasController::class, 'index'])->name('index');
        Route::post('/proses', [KenaikanKelasController::class, 'proses'])->name('proses');
    });

    Route::get('rombel/{rombel}/kenaikan',[KenaikanKelasController::class, 'preview'])->name('rombel.kenaikan.preview');
    Route::get('/rombel/{rombel}/siswa',[SiswaController::class, 'indexAll'])->name('rombel.siswa.index-all');
    
    Route::prefix('presensi')->name('presensi.')->group(function(){
        Route::get('/', [PresensiController::class, 'index'])->name('index');
        Route::post('/', [PresensiController::class, 'store'])->name('store');
        Route::get('/rekap', [PresensiController::class, 'rekap'])->name('rekap');
        Route::get('/rekap-tahunan/{rombel}', [PresensiController::class, 'rekapTahunan'])->name('rekap.tahunan');
    });

    Route::prefix('tujuan-pembelajaran')->name('tujuan-pembelajaran.')->group(function(){
    
        Route::get('/', [TujuanPembelajaranController::class, 'index'])->name('index');
    
        Route::get('/mapel/{guruMapel}/create', [TujuanPembelajaranController::class, 'create'])->name('create');
        Route::post('/mapel/{guruMapel}', [TujuanPembelajaranController::class, 'store'])->name('store');
        Route::get('/mapel/{guruMapel}', [TujuanPembelajaranController::class, 'show'])->name('show');
    
        Route::get('/tujuan/{tujuan}/edit', [TujuanPembelajaranController::class, 'edit'])->name('edit');
        Route::put('/tujuan/{tujuan}', [TujuanPembelajaranController::class, 'update'])->name('update');
        Route::delete('/tujuan/{tujuan}', [TujuanPembelajaranController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jenis-penilaian')->name('jenis-penilaian.')->group(function () {
        Route::post('/', [JenisPenilaianController::class, 'store'])->name('store');
        Route::put('/{jenisPenilaian}', [JenisPenilaianController::class, 'update'])->name('update');
        Route::delete('/{jenisPenilaian}', [JenisPenilaianController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('nilai')->name('nilai.')->group(function(){
        Route::get('/{guruMapel}', [NilaiController::class, 'index'])->name('index');
        Route::put('/{rombelSiswa}/{jenisPenilaian}', [NilaiController::class, 'store'])->name('store');
    });

    Route::prefix('dashboard-analitik')->name('dashboard.analitik.')->group(function () {
        Route::get('/', [DashboardAnalitikController::class, 'index'])->name('index');
        Route::get('/rombel/{rombel}', [DashboardAnalitikController::class, 'showRombel'])->name('rombel');
        Route::get('/mapel/{guruMapel}', [DashboardAnalitikController::class, 'showMapel'])->name('mapel');
    });
    
    Route::prefix('rekap-nilai')->name('rekap-nilai.')->group(function () {
        Route::get('/', [RekapNilaiController::class, 'index'])->name('index');
        Route::get('/{siswa}', [RekapNilaiController::class, 'show'])->name('show');
    });
});


Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');

        Route::post('/{user}/roles', [UserController::class, 'addRole'])->name('roles.add');
        Route::delete('/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('roles.remove');

        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::prefix('rombel')->name('rombel.')->group(function () {
    Route::get('/', [RombonganBelajarController::class, 'index'])->name('index');
    Route::get('/create', [RombonganBelajarController::class, 'create'])-> name('create');
    Route::post('/', [RombonganBelajarController::class, 'store'])->name('store');
    Route::get('/edit{rombel}', [RombonganBelajarController::class, 'edit'])->name('edit');
    Route::put('/{rombel}', [RombonganBelajarController::class, 'update'])->name('update');
});

Route::prefix('tahun-ajaran')->name('tahun-ajaran.')->group(function () {
    Route::get('/', [TahunAjaranController::class, 'index'])->name('index');
    Route::get('/create', [TahunAjaranController::class, 'create'])->name('create');
    Route::post('/', [TahunAjaranController::class, 'store'])->name('store');
    Route::get('/{tahunAjaran}/edit', [TahunAjaranController::class, 'edit'])->name('edit');
    Route::put('/{tahunAjaran}', [TahunAjaranController::class, 'update'])->name('update');
    Route::delete('/{tahunAjaran}', [TahunAjaranController::class, 'destroy'])->name('destroy');
});

Route::prefix('mapel')->name('mapel.')->group(function(){
    Route::get('/', [MapelController::class, 'index'])->name('index');
    Route::get('/create', [MapelController::class, 'create'])->name('create');
    Route::post('/', [MapelController::class, 'store'])->name('store');
    Route::get('/{mapel}/edit', [MapelController::class, 'edit'])->name('edit');
    Route::put('/{mapel}', [MapelController::class, 'update'])->name('update');
    Route::delete('{mapel}', [MapelController::class, 'destroy'])->name('destroy');
});


