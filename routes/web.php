<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    // Gestion des reservations
    Route::get('/reservation', function () {
        return view('reservations.form'); // Charge la vue du formulaire.
    });
    

// Route pour rediriger vers le formulaire de contact
Route::post('/reservation', function () {
    // Traitement des données du formulaire
    return back()->with('success', 'Votre message a bien été envoyé!');
});

});

require __DIR__.'/auth.php';
