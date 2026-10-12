<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\LivreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('livres.index')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Route attendue par Breeze après connexion / inscription
    Route::get('/dashboard', fn () => redirect()->route('dashboard'))
        ->name('dashboard');

    Route::resource('livres', LivreController::class)->except('destroy');

    Route::resource('categories', CategorieController::class)
        ->parameters(['categories' => 'categorie'])
        ->except('destroy');

    Route::resource('emprunts', EmpruntController::class)->except('destroy');
    Route::patch('/emprunts/{emprunt}/retour', [EmpruntController::class, 'retour'])
        ->name('emprunts.retour');
});

/*
|--------------------------------------------------------------------------
| Réservé à l'admin : suppressions et comptes du personnel
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::delete('/livres/{livre}', [LivreController::class, 'destroy'])->name('livres.destroy');
    Route::delete('/categories/{categorie}', [CategorieController::class, 'destroy'])->name('categories.destroy');
    Route::delete('/emprunts/{emprunt}', [EmpruntController::class, 'destroy'])->name('emprunts.destroy');

    Route::get('/users/create', [RegisteredUserController::class, 'create'])->name('users.create');
    Route::post('/users', [RegisteredUserController::class, 'store'])->name('users.store');
});

require __DIR__.'/auth.php';