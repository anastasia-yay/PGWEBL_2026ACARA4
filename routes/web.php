<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/peta', [PagesController::class, 'peta'])->name('peta');

Route::get('/tabel', [PagesController::class, 'tabel'])->name('tabel');

//  Points
Route::post('/store-points', [PointsController::class, 'store'])
->name('point.store');

//  Polylines
Route::post('/store-polylines', [PolylinesController::class, 'store'])
->name('polyline.store');

//  Polygons
Route::post('/store-polygons', [PolygonsController::class, 'store'])
->name('polygon.store');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
