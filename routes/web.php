<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/checks',[CheckController::class, 'index'])->name('checks.index');
Route::put('/checks/{id}',[CheckController::class, 'update'])->name('checks.update');
Route::post('/checks/{id}/record',[CheckController::class, 'create'])->name('checks.record');

Route::get('/charts',[ChartController::class, 'index'])->name('charts.index');
Route::post('/charts/{recurringInstanceId}',[ChartController::class, 'getChartData'])->name('charts.getChartData');

Route::resources([
    'todos' => TodoController::class,
    // 'checks' => CheckController::class,
]);
require __DIR__.'/auth.php';
