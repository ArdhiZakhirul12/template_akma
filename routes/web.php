<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\incomeController;
use App\Http\Controllers\kelasController;
use App\Http\Controllers\pemasukanController;
use App\Http\Controllers\pembukuanController;
use App\Http\Controllers\pengeluaranController;
use App\Http\Controllers\rabcontroller;
use App\Http\Controllers\siswaController;
use App\Livewire\siswa\Siswa as LivewireSiswa;
use App\Livewire\siswa\Detail as LivewireDetail;
use App\Livewire\pemasukan\Detail as LivewirePemasukanDetail;
use App\Livewire\Pengeluaran\Detail as LivewirePengeluaranDetail;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {

   
    // Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'pemasukan', 'as' => 'pemasukan.'], function () {
        Route::get('/', [pemasukanController::class, 'index'])->name('index');
        Route::get('/income', [incomeController::class, 'incomeIndex'])->name('incomeIndex');
        Route::get('/calender/{id}', [pemasukanController::class, 'calender'])->name('calender');
        // Route::get('/create', [pemasukanController::class, 'create'])->name('create');
        Route::post('/store', [pemasukanController::class, 'store'])->name('store');
        Route::put('/{id}', [pemasukanController::class, 'update'])->name('update');
        Route::get('/{id}', [pemasukanController::class, 'show'])->name('show');
        // Route::get('/{id}', LivewirePemasukanDetail::class)->name('show');
    });

    Route::group(['prefix' => 'pengeluaran', 'as' => 'pengeluaran.'], function () {
        Route::get('/', [pengeluaranController::class, 'index'])->name('index');
        Route::get('/create', [pengeluaranController::class, 'create'])->name('create');
        Route::post('/store', [pengeluaranController::class, 'store'])->name('store');
        Route::put('/{id}', [pengeluaranController::class, 'update'])->name('update');
        // Route::get('/{id}', [pengeluaranController::class, 'show'])->name('show');
        Route::get('/{id}', LivewirePengeluaranDetail::class)->name('show');
    });

    Route::group(['prefix' => 'rab', 'as' => 'rab.'], function () {
        Route::group(['prefix' => 'bank', 'as' => 'bank.'], function (){
            Route::put('/', [rabcontroller::class, 'updateBank'])->name('update');
        });
        Route::get('/', [rabcontroller::class, 'index'])->name('index');
        Route::post('/', [rabcontroller::class, 'store'])->name('store');
        Route::post('/sub', [rabcontroller::class, 'subStore'])->name('subStore');
        Route::get('/rekap/{id}', [rabcontroller::class, 'showRekap'])->name('showRekap');
        Route::put('/kategori/{id}', [rabcontroller::class, 'update'])->name('update');
        Route::put('/kategori/sub/{id}', [rabcontroller::class, 'subUpdate'])->name('subEdit');
        Route::get('kategori/{id}', [rabcontroller::class, 'show'])->name('show');
        Route::get('kategori/uraian/{id}', [rabcontroller::class, 'uraianShow'])->name('uraianShow');
        Route::post('kategori/uraian', [rabcontroller::class, 'uraianStore'])->name('uraianStore');
        Route::get('kategori/uraian/detail/{id}', [rabcontroller::class, 'showUraian'])->name('showUraian');
        Route::put('kategori/uraian/edit/{id}', [rabcontroller::class, 'uraianUpdate'])->name('uraianUpdate');
    });
    Route::group(['prefix' => 'siswa', 'as' => 'pages.siswa.'], function () {
        // Route::get('/', [siswaController::class, 'index'])->name('index');
        Route::get('/', LivewireSiswa::class)->name('index');
        Route::post('/store', [siswaController::class, 'store'])->name('store');
        Route::put('/{id}', [siswaController::class, 'update'])->name('update');
        // Route::get('/{id}', [siswaController::class, 'show'])->name('show');
        Route::get('/{id}', LivewireDetail::class)->name('show');
    });

    Route::group(['prefix' => 'kelas', 'as' => 'kelas.'], function () {
        Route::get('/', [kelasController::class, 'index'])->name('index');
        Route::put('/spp', [kelasController::class, 'updateSpp'])->name('updateSpp1');
        Route::post('/store', [kelasController::class, 'store'])->name('store');
        Route::put('/{id}', [kelasController::class, 'update'])->name('update');
        Route::get('/{id}', [kelasController::class, 'siswa_kelas_list'])->name('siswa_kelas_list');
        // Route::put('/{id}', [kelasController::class, 'update'])->name('update');
        // Route::get('/{id}', [kelasController::class, 'show'])->name('show');
    });

    Route::group(['prefix' => 'pembukuan', 'as' => 'pembukuan.'], function () {
        Route::get('/', [
            pembukuanController::class,
            'index'
        ])->name('index');
        Route::get('/list/{id}/{inputYear}/{inputMonth}', [pembukuanController::class, 'listPembukuan'])->name('listPembukuan');
        Route::get('/pdf_printed', [pembukuanController::class, 'cetak_pdf'])->name('cetak_pdf');
    });

    // Route::view('pages.siswa.index', 'pages.siswa.index')->name('pages.siswa.index');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
