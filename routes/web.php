<?php

use App\Http\Livewire\ProfileController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\ActivosController;
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

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::middleware(['auth'])->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get(uri: 'profile', action: ProfileController::class)->name(name: 'profile');
        Route::get(uri: 'users', action: UsersController::class)->name(name: 'users');
        Route::get(uri: 'activos', action: ActivosController::class)->name(name: 'activos');
    });
});
Route::get('/', function () {
    return view('welcome');
});
require __DIR__ . '/auth.php';
