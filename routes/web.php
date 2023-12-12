<?php

use App\Http\Controllers\ApiReceita;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::get('/home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('recipes')->group(function () {
        Route::get('/create', [RecipesController::class, 'create'])->name('recipes.create');
        Route::post('/store', [RecipesController::class, 'store'])->name('recipes.store');
        Route::get('/list', [RecipesController::class, 'list'])->name('recipes.list');
        Route::delete('/{id}', [RecipesController::class, 'destroy'])->name('recipes.delete');
        Route::get('/{id}/edit', [RecipesController::class, 'edit'])->name('recipes.edit');
        Route::put('/{id}', [RecipesController::class, 'update'])->name('recipes.update');
    });
});

require __DIR__.'/auth.php';
