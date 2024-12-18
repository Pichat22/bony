<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Route d'accueil redirigeant vers la connexion
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes accessibles uniquement par les administrateurs
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Tableau de bord Admin
    Route::get('/dashboards', [DashboardController::class, 'index'])->name('dashboard.index');

    // Gestion des utilisateurs
    Route::get('/users', [RegisteredUserController::class, 'allusers'])->name('users.index');
    Route::get('/users/{id}/edit-role', [RegisteredUserController::class, 'editRole'])->name('users.edit.role');
    Route::patch('/users/{id}/role', [RegisteredUserController::class, 'updateRole'])->name('users.update.role');
 
        Route::get('/reservations/admin', [ReservationController::class, 'indexAdmin'])->name('reservations.admin.index');
    
});

// Routes accessibles pour les utilisateurs authentifiés
Route::middleware('auth')->group(function () {
    
  // Dashboard utilisateur connecté
        Route::get('/dashboard', function () {
            $user = Auth::user();
    
            // Récupérer les réservations de l'utilisateur connecté
            $hotelReservations = \App\Models\Reservation::where('user_id', $user->id)
                ->where('type_reservation', 'hotel')
                ->get();
    
            $flightReservations = \App\Models\Reservation::where('user_id', $user->id)
                ->where('type_reservation', 'billet')
                ->get();
    
            return view('dashboard', compact('hotelReservations', 'flightReservations'));
        })->middleware(['auth', 'verified'])->name('dashboard');
  
    

    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestion des réservations
    Route::resource('reservations', ReservationController::class);
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/search', [ReservationController::class, 'search'])->name('reservations.search');
    Route::post('/reservations/searchs', [ReservationController::class, 'search'])->name('reservations.search.post');
    Route::get('/api/search-cities', [ReservationController::class, 'searchCities']);
    // Recherche de vols
    Route::get('/flights', [ReservationController::class, 'showSearchForm'])->name('flights.form');
    Route::get('/flights/search', [ReservationController::class, 'searchFlights'])->name('flights.search');

    // Gestion des hôtels
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
    Route::get('/hotels/search', [HotelController::class, 'showHotelSearchForm'])->name('hotels.search.form');
    Route::post('/hotel/search', [HotelController::class, 'searchHotels'])->name('hotels.search');
    Route::get('/api/cities', [HotelController::class, 'searchCities'])->name('api.cities');
    Route::get('/reservations/hotel/create', [ReservationController::class, 'createHotelReservation'])->name('reservations.create.hotel');
    Route::post('/reservations/hotel/store', [ReservationController::class, 'storeHotelReservation'])->name('reservations.store.hotel');
    
});

require __DIR__.'/auth.php';
