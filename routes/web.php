<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user=Auth::user();
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    
    // Recherche et gestion des réservations

    Route::resource('reservations', ReservationController::class);
    // Route::post('reservations/search', [ReservationController::class, 'search'])->name('reservations.search');
    
    // Route::get('/user_reservation', [ReservationController::class, 'ReservationByUser'])->name('reservations.user');
    // Route::get('reservations/{id}/download', [ReservationController::class, 'downloadPDF'])->name('reservations.download');
    // Route::post('/reservations/hotel', [ReservationController::class, 'storeHotel'])->name('reservations.hotel.store');
    

    Route::resource('hotels', HotelController::class);
    Route::get('/flights', [ReservationController::class, 'showSearchForm'])->name('flights.form');
    Route::get('/flights/search', [ReservationController::class, 'searchFlights'])->name('flights.search');
    
    Route::get('/api/search-cities', [ReservationController::class, 'searchCities']);
    Route::post('reservations/search', [ReservationController::class, 'search'])->name('reservations.search');
    
    // Gestion des utilisateurs

    // Route pour afficher le formulaire de l'utiisateur
    Route::get('/user', function () {
        return view('users.form'); // Charge la vue du formulaire.
    });
    

// Route pour rediriger vers le formulaire de l'utilisateur
Route::post('/user', function () {
    // Traitement des données du formulaire
    return back()->with('success', 'Création avec success');
});
    
});

require __DIR__.'/auth.php';
