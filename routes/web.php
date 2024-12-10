<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;

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


    
    // Recherche et gestion des réservations
    Route::resource('reservations', ReservationController::class);
    Route::post('reservations/search', [ReservationController::class, 'search'])->name('reservations.search');
    
    Route::get('/user_reservation', [ReservationController::class, 'ReservationByUser'])->name('reservations.user');
    Route::get('reservations/{id}/download', [ReservationController::class, 'downloadPDF'])->name('reservations.download');
    Route::post('/reservations/hotel', [ReservationController::class, 'storeHotel'])->name('reservations.hotel.store');
    

    Route::resource('hotels', HotelController::class);

});

require __DIR__.'/auth.php';
