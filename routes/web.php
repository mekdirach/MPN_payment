<?php

use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Dashboard\NomorsaktiCotroller;
use App\Http\Controllers\Dashboard\PelimpahanController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TransaksiControllerApi;
use App\Http\Controllers\CaptchaServiceController;
use App\Http\Controllers\Dashboard\CekStatusPaymentController;
use App\Http\Controllers\Dashboard\ForceFlagingController;
use App\Http\Controllers\Dashboard\HolidayController;
use App\Http\Controllers\Dashboard\LaporanController;
use App\Http\Controllers\Dashboard\LaporanTransaksiController;
use App\Http\Controllers\Dashboard\LaporanTransaksiNonAhuController;
use App\Http\Controllers\Dashboard\ManualReversalController;
use App\Http\Controllers\Dashboard\MpnStatusKoneksiController;
use App\Http\Controllers\Dashboard\ParameterSistemController;
use App\Http\Controllers\Dashboard\roleManagementController;
use App\Http\Controllers\Dashboard\SetiingKementrianController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\TransaksiController;
use App\Models\holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/welcome', function () {
    return view('welcome');
});



//Route::get('/login', [RegisterController::class, 'login'])->name('login');

Route::get('/', [CaptchaServiceController::class, 'masuk'])->name('login');

Route::post('/captcha-validation', [CaptchaServiceController::class, 'capthcaFormValidate']);
Route::get('/reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha']);

//Route::post('login', [RegisterController::class, 'login'])->name('login.landing');
Route::post('login', [RegisterController::class, 'login'])->name('login.landing');
Route::get('reload', [RegisterController::class, 'relogin_login'])->name('reload.landing');
Route::post('register', [RegisterController::class, 'register'])->name('register.landing');

Route::group(['prefix' => 'member', 'as' => 'member.', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('dashboard', [MemberController::class, 'index'])->name('dashboard.index');
    // Route::get('dashboard', [MemberController::class, 'index']);


    //Transaksi
    Route::get('holiday', [HolidayController::class, 'index'])->name('holiday.index');
    // Route::resource('holiday', HolidayController::class);
    Route::post('holiday/input', [HolidayController::class, 'input'])->name('holiday.input');
    Route::get('/holiday/search', [HolidayController::class, 'store']);
    Route::put('/holiday/update/{id}', [HolidayController::class, 'update']);
    Route::delete('/holiday/deleteby/{id}', [HolidayController::class, 'destroy']);


   Route::get('rolemanagement', [roleManagementController::class, 'index'])->name('rolemanagement.index');
    //Route::resource('rolemanagement', roleManagementController::class);
    Route::post('rolemanagement/input', [roleManagementController::class, 'store'])->name('rolemanagement.input');
    Route::put('rolemanagement/update', [roleManagementController::class, 'update'])->name('rolemanagement.update');
    Route::delete('rolemanagement/delete/{id}', [roleManagementController::class, 'destroy']);
    Route::post('logout', [RegisterController::class, 'logout'])->name('logout.landing');
});

Route::group(['prefix' => 'trans', 'as' => 'trans.', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //Transaksi
    Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/search', [TransaksiController::class, 'store'])->name('transaksi.search');
    Route::post('/transaksi/cari', [TransaksiController::class, 'store'])->name('transaksi.cari');

    //Route::resource('transaksi', TransaksiController::class);

    //laporan Transaksi AHU
    Route::get('transaksiahu', [LaporanTransaksiController::class, 'index'])->name('transaksiahu.index');
    Route::get('/transaksiahu/search', [LaporanTransaksiController::class, 'store'])->name('transaksiahu.search');
    // Route::resource('transaksiahu', LaporanTransaksiController::class);

    //laporan Transaksi Non AHU
    Route::get('transaksinonahu', [LaporanTransaksiNonAhuController::class, 'index'])->name('transaksinonahu.index');
    Route::get('/transaksinonahu/search', [LaporanTransaksiNonAhuController::class, 'store'])->name('transaksinonahu.search');
    //Route::resource('transaksinonahu', LaporanTransaksiNonAhuController::class);
});

Route::group(['prefix' => 'limpahkan', 'as' => 'limpahkan.', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //Pelimpahan
    Route::get('pelimpahan', [PelimpahanController::class, 'index'])->name('pelimpahan.index');
    Route::post('pelimpahan/limpahkan', [PelimpahanController::class, 'store']);

    //nomor sakti
    Route::get('nomorsakti', [NomorsaktiCotroller::class, 'index'])->name('nomorsakti.index');
    Route::post('nomorsakti/telahlimpahkan', [NomorsaktiCotroller::class, 'store']);
    Route::post('nomorsakti/sukses', [NomorsaktiCotroller::class, 'pre_submit']);
	 Route::post('nomorsakti/check-nomor-sakti', [NomorsaktiCotroller::class, 'checkNomorSakti']);
    //Route::resource('nomorsakti', NomorsaktiCotroller::class);

    //LAporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('laporan/upload', [LaporanController::class, 'store']);
    Route::get('laporan/list', [LaporanController::class, 'show']);
	Route::get('laporan/detail/{url}', [LaporanController::class, 'getUrl']);
});


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:sanctum', 'verified']], function () {

    //Mpn Status Koneksi
    Route::get('mpnstatuskoneksi', [MpnStatusKoneksiController::class, 'index'])->name('mpnstatuskoneksi.index');
    Route::post('mpnstatus/koneksi', [MpnStatusKoneksiController::class, 'store']);
    //Route::get('mpnstatus', [MpnStatusKoneksiController::class, 'index'])->name('mpnstatus.index');

    // Route::resource('mpnstatus', MpnStatusKoneksiController::class);

    //Force Flaging
    Route::get('force', [ForceFlagingController::class, 'index'])->name('force.index');
    //Route::get('force/getdata', [ForceFlagingController::class, 'create']);
    Route::get('force/flagingdata', [ForceFlagingController::class, 'store']);
    Route::put('force/flalaging/aksi', [ForceFlagingController::class, 'show']);
    // Route::resource('force', ForceFlagingController::class);

    //Manual Reveral
    Route::get('manualreveral', [ManualReversalController::class, 'index'])->name('manualreveral.index');
    Route::post('/manualreveral/search', [ManualReversalController::class, 'store']);
    Route::post('/manualreveral/search/{id}', [ManualReversalController::class, 'show']);
    Route::post('/manualreveral/search', [ManualReversalController::class, 'store']);
    Route::post('/manualreveral/search/{id}', [ManualReversalController::class, 'show']);
    Route::put('/manualreveral/aksi', [ManualReversalController::class, 'action']);

    //Route::resource('manualreveral', ManualReversalController::class);

    //Cek Status Payment
    Route::get('cekstatus', [CekStatusPaymentController::class, 'index'])->name('cekstatus.index');
    Route::post('/cekstatus/search', [CekStatusPaymentController::class, 'store']);
    Route::post('/cekstatus/search/{id}', [CekStatusPaymentController::class, 'show']);
    Route::put('/cekstatus/aksi', [CekStatusPaymentController::class, 'action']);
});

Route::group(['prefix' => 'setting', 'as' => 'setting.', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //Setting
    Route::get('pengaturan', [SettingController::class, 'index'])->name('pengaturan.index');
    Route::get('pengaturan/getdata', [SettingController::class, 'create']);
    Route::put('pengaturan/update/{id}', [SettingController::class, 'update']);
    //Route::resource('pengaturan', SettingController::class);

    //Setting Kementrian
    Route::get('settingkementrian', [SetiingKementrianController::class, 'index'])->name('settingkementrian.index');
    Route::get('settingkementrian/getdata', [SetiingKementrianController::class, 'create']);
    Route::get('settingkementrian/getby/{id}', [SetiingKementrianController::class, 'show']);
    Route::put('settingkementrian/getbysave/{id}', [SetiingKementrianController::class, 'update']);
    Route::delete('settingkementrian/deleteby/{id}', [SetiingKementrianController::class, 'destroy']);
    Route::get('settingkementrian/add/{id}', [SetiingKementrianController::class, 'add']);
    // Route::resource('settingkementrian', SetiingKementrianController::class);

    //ParameterSistem
    Route::get('parametersistem', [ParameterSistemController::class, 'index'])->name('parametersistem.index');
    //Route::resource('parametersistem', ParameterSistemController::class);
});
