<?php

use App\Http\Controllers\HarianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\TargetController;
use Illuminate\Support\Facades\Route;

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


/*
| Setiap return view memerlukan variabel $title => untuk memberi judul halaman
| 
|*/

Route::get('/', function () {
    return redirect('/periode');
});

// Menangani CRUD rekening
Route::get("/rekening", [RekeningController::class, "index"])->name("rekening.index");
Route::post("/rekening/tambah", [RekeningController::class, "store"])->name("rekening.tambah");
Route::put("/rekening/edit/", [RekeningController::class, "update"])->name("rekening.edit");
Route::delete("/rekening/delete/", [RekeningController::class, "delete"])->name("rekening.delete");


// Menangani CRUD periode
Route::get("/periode", [PeriodeController::class, 'index'])->name("periode.index");
Route::post("/periode/tambah", [PeriodeController::class, 'store'])->name("periode.tambah");


// Menangani CRUD Target
Route::get("/target", [TargetController::class, 'index'])->name('target.index');
Route::post("/target/tambah", [TargetController::class, 'store'])->name('target.tambah');
Route::put("/target/edit", [TargetController::class, 'update'])->name('target.edit');
Route::delete("/target/delete", [TargetController::class, "delete"])->name("target.delete");


// Menangani CRUD Harian
Route::get("/harian", [HarianController::class, "index"])->name("harian.index");
Route::post("/harian/tambah", [HarianController::class, "store"])->name("harian.tambah");
Route::put("/harian/edit", [HarianController::class, "update"])->name("harian.edit");
Route::delete("/harian/delete", [HarianController::class, "delete"])->name("harian.delete");

// Menangani Laporan
Route::get("laporan", [LaporanController::class, "index"])->name("laporan.index");
Route::get("laporan/{idPeriode}", [LaporanController::class, "detail"])->name("laporan.detail");
Route::post("laporan/{idPeriode}/search", [LaporanController::class, "detail_search"])->name("laporan.detail");
