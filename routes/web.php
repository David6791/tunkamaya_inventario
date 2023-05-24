<?php

use App\Http\Livewire\ProfileController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\ActivosController;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\DepartamentosController;
use App\Http\Livewire\ProvinciasController;
use App\Http\Livewire\MunicipiosController;
use App\Http\Livewire\LocalidadesController;
use App\Http\Livewire\BloqueController;
use App\Http\Livewire\ResponsablesController;
use App\Http\Livewire\AreasController;
use App\Http\Livewire\TiposController;
use App\Http\Livewire\SubTiposController;
use App\Http\Livewire\GruposController;

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
        Route::get(uri: 'departamentos', action: DepartamentosController::class)->name(name: 'departamentos');
        Route::get(uri: 'provincias', action: ProvinciasController::class)->name(name: 'provincias');
        Route::get(uri: 'municipios', action: MunicipiosController::class)->name(name: 'municipios');
        Route::get(uri: 'localidades', action: LocalidadesController::class)->name(name: 'localidades');
        Route::get(uri: 'bloques', action: BloqueController::class)->name(name: 'bloques');
        Route::get(uri: 'responsables', action: ResponsablesController::class)->name(name: 'responsables');
        Route::get(uri: 'areas', action: AreasController::class)->name(name: 'areas');
        Route::get(uri: 'tipos', action: TiposController::class)->name(name: 'tipos');
        Route::get(uri: 'grupos', action: GruposController::class)->name(name: 'grupos');
        Route::get(uri: 'subtipos', action: SubTiposController::class)->name(name: 'subtipos');
    });
});
Route::get('/', function () {
    return view('welcome');
});
require __DIR__ . '/auth.php';
