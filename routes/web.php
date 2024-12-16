<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    // Récupérer les réservations de l'utilisateur connecté
    $userReservations = \App\Models\Reservation::where('user_id', $user->id)->get();

    return view('dashboard', compact('userReservations'));
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
    

  //  Route::resource('hotels', HotelController::class);
    Route::get('/flights', [ReservationController::class, 'showSearchForm'])->name('flights.form');
    Route::get('/flights/search', [ReservationController::class, 'searchFlights'])->name('flights.search');
    Route::get('/reservations/search', [ReservationController::class, 'search'])->name('reservations.search');
    Route::get('/api/search-cities', [ReservationController::class, 'searchCities']);
   Route::post('/reservations/searchs', [ReservationController::class, 'search'])->name('reservations.search.post');
   Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
   Route::get('/api/cities', [HotelController::class, 'searchCities'])->name('api.cities');

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
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');

// Route pour enregistrer les données de la réservation
Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/hotels/search', [HotelController::class, 'showHotelSearchForm'])->name('hotels.search.form');
Route::post('/hotel/search', [HotelController::class, 'searchHotels'])->name('hotels.search');
Route::get('/dashboards', [DashboardController::class, 'index'])->name('dashboard.index');

});

require __DIR__.'/auth.php';
