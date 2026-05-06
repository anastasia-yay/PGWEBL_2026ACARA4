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

Route::get('/geojson/points', [PointsController::class, 'geojson'])->name('geojson.points');
Route::get('/geojson/polylines', [PolylinesController::class, 'geojson'])->name('geojson.polylines');
Route::get('/geojson/polygons', [PolygonsController::class, 'geojson'])->name('geojson.polygons');

//  Points
Route::post('/store-points', [PointsController::class, 'store'])
->name('point.store');

Route::delete('/delete-points/{id}', [PointsController::class,
'destroy'])->name('point.delete');

//  Polylines
Route::post('/store-polylines', [PolylinesController::class, 'store'])
->name('polyline.store');

Route::delete('/delete-polylines/{id}', [PolylinesController::class,
'destroy'])->name('polyline.delete');

//  Polygons
Route::post('/store-polygons', [PolygonsController::class, 'store'])
->name('polygon.store');

Route::delete('/delete-polygons/{id}', [PolygonsController::class,
'destroy'])->name('polygon.delete');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
