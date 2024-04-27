<?php

use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RekeningController;
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
// Route::get("")
