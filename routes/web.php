<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\ExpiredController;
use App\Http\Controllers\LogisticController;
use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\LogisticTypeController;
use App\Http\Controllers\ReceiverUnitController;
use App\Http\Controllers\StandardUnitController;
use App\Http\Controllers\LogisticStockController;
use App\Http\Controllers\ExpiredLogisticController;
use App\Http\Controllers\InboundLogisticController;
use App\Http\Controllers\OutboundLogisticController;
use App\Http\Controllers\LogisticProcurementController;
use App\Http\Controllers\InboundLogisticReportController;
use App\Http\Controllers\OutboundLogisticReportController;

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

// Sign In
Route::get('/', [SignInController::class, 'index'])
    ->name('sign-in')
    ->middleware('guest');
Route::post('/', [SignInController::class, 'authenticate'])
    ->middleware('guest');

// Sign Out
Route::post('/dashboard/sign-out', [SignInController::class, 'signOut'])
    ->middleware('auth');

// Sign Up
Route::resource('/sign-up', SignUpController::class)
    ->except([
        'create',
        'show',
        'edit',
        'update',
        'destroy'
    ])
    ->middleware('guest');

// Beranda
Route::resource('/dashboard/beranda', HomeController::class)
    ->except([
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ])
    ->middleware('auth');

// Level
Route::resource('/data-master/level', LevelController::class)
    ->except([
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ])
    ->middleware('auth');

// Pengguna
Route::post('/data-master/pengguna/edit-password/{id}', [UserController::class, 'changePassword'])
    ->middleware('auth');
Route::put('/data-master/pengguna/edit-foto/{id}', [UserController::class, 'editPhoto'])
    ->middleware('auth');
Route::resource('/data-master/pengguna', UserController::class)
    ->except([
        'create',
        'show',
        'edit',
    ])
    ->middleware('auth');

// Unit Penerima
Route::resource('/data-master/unit-penerima', ReceiverUnitController::class)
    ->except([
        'create',
        'show',
        'edit',
    ])
    ->middleware('pegawai');

// Penerima
Route::resource('/data-master/penerima', ReceiverController::class)
    ->except([
        'create',
        'show',
        'edit',
    ])
    ->middleware('pegawai');

// Jenis Pengadaan
Route::resource('/data-master/jenis-pengadaan', LogisticProcurementController::class)
    ->except([
        'create',
        'show',
        'edit',
    ])
    ->middleware('pegawai');

// Jenis Logistik
Route::resource('/data-master/jenis-logistik', LogisticTypeController::class)
    ->except([
        'create',
        'show',
        'edit',
    ])
    ->middleware('pegawai');

// Satuan
Route::resource('/data-master/satuan', StandardUnitController::class)
    ->except([
        'create',
        'show',
        'edit',
    ])
    ->middleware('pegawai');

// Logistik
Route::resource('/data-master/logistik', LogisticController::class)
    ->except([
        'create',
        'show',
        'edit',
    ])
    ->middleware('pegawai');

// Penyuplai
Route::resource('/data-master/penyuplai', SupplierController::class)
    ->except([
        'create',
        'show',
        'edit',
    ])
    ->middleware('pegawai');

// Logistik Masuk
// Route::get('/transaksi/logistik-masuk/json', function () {
//     $logistics = Logistic::all();
//     return DataTables::of($logistics)
//         ->addColumn('id', function (Logistic $logistic) {
//             return '<input class="form-check-input" type="checkbox" name="logistic_id[]" value="' . $logistic->id . '">';
//         })
//         ->addColumn('amount', function () {
//             return '<input type="text" class="form-control" name="amount[]">';
//         })
//         ->addColumn('standardUnit_id', function (Logistic $logistic) {
//             return $logistic->standardUnit->name;
//         })
//         ->addColumn('expiredDate', function (Logistic $logistic) {
//             if ($logistic->logisticType->expiredDate == 0) {
//                 return '<input type="hidden" name="expiredDate[]" value="">';
//             } elseif ($logistic->logisticType->expiredDate == 1) {
//                 return '<input type="text" class="form-control date-picker" name="expiredDate[]">';
//             }
//         })
//         ->rawColumns(['action', 'id', 'amount', 'expiredDate'])
//         ->make(true);
// })->name('logistik-masuk')->middleware('pegawai');
Route::get('/transaksi/logistik-masuk/sort', [InboundLogisticController::class, 'sortDate'])
    ->middleware('pegawai');
Route::post('/transaksi/logistik-masuk/reset', [InboundLogisticController::class, 'resetDate'])
    ->middleware('pegawai');
Route::resource('/transaksi/logistik-masuk', InboundLogisticController::class)
    ->except([
        'create',
        'show',
        'edit',
        'update',
    ])
    ->middleware('pegawai');

// Logistik Keluar
Route::get('/transaksi/logistik-keluar/sort', [OutboundLogisticController::class, 'sortDate'])
    ->middleware('pegawai');
Route::post('/transaksi/logistik-keluar/reset', [OutboundLogisticController::class, 'resetDate'])
    ->middleware('pegawai');
Route::resource('/transaksi/logistik-keluar', OutboundLogisticController::class)
    ->except([
        'create',
        'show',
        'edit',
        'update',
    ])
    ->middleware('pegawai');

Route::get('/transaksi/logistik-kedaluwarsa/sort', [ExpiredLogisticController::class, 'sortDate'])
    ->middleware('pegawai');
Route::post('/transaksi/logistik-kedaluwarsa/reset', [ExpiredLogisticController::class, 'resetDate'])
    ->middleware('pegawai');
Route::resource('/transaksi/logistik-kedaluwarsa', ExpiredLogisticController::class)
    ->except([
        'create',
        'show',
        'edit',
        'update',
    ])
    ->middleware('pegawai');

// Laporan Logistik Masuk
Route::get('/laporan/logistik-masuk/sort', [InboundLogisticReportController::class, 'sortDate'])
    ->middleware('kabid');
Route::post('/laporan/logistik-masuk/reset', [InboundLogisticReportController::class, 'resetDate'])
    ->middleware('kabid');
Route::get('/laporan/logistik-masuk/print', [InboundLogisticReportController::class, 'print'])
    ->middleware('kabid');
Route::get('/laporan/logistik-masuk/ekspor', [InboundLogisticReportController::class, 'export'])
    ->middleware('kabid');
Route::resource('/laporan/logistik-masuk', InboundLogisticReportController::class)
    ->except([
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ])
    ->middleware('kabid');

// Laporan Logistik Keluar
Route::get('/laporan/logistik-keluar/sort', [OutboundLogisticReportController::class, 'sortDate'])
    ->middleware('kabid');
Route::post('/laporan/logistik-keluar/reset', [OutboundLogisticReportController::class, 'resetDate'])
    ->middleware('kabid');
Route::get('/laporan/logistik-keluar/print', [OutboundLogisticReportController::class, 'print'])
    ->middleware('kabid');
Route::get('/laporan/logistik-keluar/ekspor', [OutboundLogisticReportController::class, 'export'])
    ->middleware('kabid');
Route::resource('/laporan/logistik-keluar', OutboundLogisticReportController::class)
    ->except([
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ])
    ->middleware('kabid');

// Stok Logistik
Route::get('/laporan/stok-logistik/print', [LogisticStockController::class, 'print'])
    ->middleware('kabid');
Route::get('/laporan/stok-logistik/ekspor/pdf', [LogisticStockController::class, 'pdf'])
    ->middleware('kabid');
Route::get('/laporan/stok-logistik/ekspor/ods', [LogisticStockController::class, 'ods'])
    ->middleware('kabid');
Route::get('/laporan/stok-logistik/ekspor/xls', [LogisticStockController::class, 'xls'])
    ->middleware('kabid');
Route::get('/laporan/stok-logistik/ekspor/xlsx', [LogisticStockController::class, 'xlsx'])
    ->middleware('kabid');
Route::resource('/laporan/stok-logistik', LogisticStockController::class)
    ->except([
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ])
    ->middleware('kabid');

// Kedaluwarsa
Route::get('/laporan/logistik-kedaluwarsa/print', [ExpiredController::class, 'print'])
    ->middleware('kabid');
Route::get('/laporan/logistik-kedaluwarsa/ekspor/pdf', [ExpiredController::class, 'pdf'])
    ->middleware('kabid');
Route::get('/laporan/logistik-kedaluwarsa/ekspor/ods', [ExpiredController::class, 'ods'])
    ->middleware('kabid');
Route::get('/laporan/logistik-kedaluwarsa/ekspor/xls', [ExpiredController::class, 'xls'])
    ->middleware('kabid');
Route::get('/laporan/logistik-kedaluwarsa/ekspor/xlsx', [ExpiredController::class, 'xlsx'])
    ->middleware('kabid');
Route::resource('/laporan/logistik-kedaluwarsa', ExpiredController::class)
    ->except([
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ])
    ->middleware('kabid');
