<?php

use Illuminate\Support\Facades\Route;
// use : import file
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

# route :: httpMethod('/isi-path'), [NamaController::class, 'namaFunc'] ->name('identitas_unique_route')
# http Method
# 1 get -> mengambil data/menampilkan halaman
# 2 post -> menambahkan data ke db
# 3 put/patch -> mengupdate data ke db
# 4 delete -> menghapus data dari db

//mengelola data obat
// Route::get('/create', [MedicineController::class, 'index'])->name('data_obat');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('pages/index');
// });
// Route::get('/about', function () {
//     return view('pages/about');
// });
// Route::get('/contact', function () {
//     return view('pages/contact');
// });


// Route::post()
// Route::put()
// Route::patch()
// Route::delete()
Route::middleware(['isGuest'])->group(function(){
    Route::get('/', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.proses');
});

Route::middleware(['isLogin'])->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/landing', [LandingPageController::class, 'index'])->name('landing_page');

    Route::middleware(['IsAdmin'])->group(function () {
        Route::get('/order', [OrderController::class, 'indexAdmin'])->name('pembelian.admin');

        Route::get('/order/export-excel', [OrderController::class, 'exportExcel'])->name('pembelian.admin.export');
        Route::get('/kelola_akun/export-excel', [UserController::class, 'exportExcelAkun'])->name('kelola.akun.admin');
        Route::get('/obat/data-obat/export-excel', [MedicineController::class, 'exportExcelObat'])->name('obat.data.export');

        Route::prefix('/obat')->name('obat.')->group(function () {
            Route::get('data', [MedicineController::class, 'index'])->name('data');
            Route::get('/tambah', [MedicineController::class, 'create'])->name('tambah');
            Route::post('/tambah', [MedicineController::class, 'store'])->name('tambah.formulir');
            Route::delete('/hapus/{id}', [MedicineController::class, 'destroy'])->name('hapus');
            Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('edit.formulir');
            Route::patch('/edit/stock/{id}', [MedicineController::class, 'updateStock'])->name('edit.stock');
        });
        Route::prefix('/kelola')->name('kelola.')->group(function () {
            Route::get('/kelola-akun', [UserController::class, 'index'])->name('akun');
            Route::get('/tambah', [UserController::class, 'create'])->name('tambah');
            Route::post('/tambah', [UserController::class, 'store'])->name('tambah.formulir');
            Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('hapus');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [UserController::class, 'update'])->name('edit.formulir');
        });
    });

    Route::middleware('isKasir')->group(function() {
        Route::prefix('/pembelian')->name('pembelian.')->group(function () {
            Route::get('/order', [OrderController::class, 'index'])->name('order');
            Route::get('/formulir', [OrderController::class, 'create'])->name('formulir');
            Route::post('/store-order', [OrderController::class, 'store'])->name('formulir.proses');
            Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
            Route::get('/download-pdf/{id}', [OrderController::class, 'downloadPDF'])->name('download_pdf');
        });
    });

});

// fitur/bagian fitur
// Route::prefix('/obat-kelola')->name('kelola-akun.')->group(function () {
// Route::get('/kelola-akun', [UserController::class, 'index'])->name('kelola.akun');
// });

// Route::resource('users', UserController::class);
// Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('akun.hapus');




