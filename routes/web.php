<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PointsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/peta', [PagesController::class, 'peta'])->name('peta');

Route::get('/tabel', [PagesController::class, 'tabel'])->name('tabel');

//  Points
Route::post('/store-points', [PointsController::class, 'store'])
->name('point.store');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
