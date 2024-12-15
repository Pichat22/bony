<?php
use App\Models\Compagnie;
use Illuminate\Support\Facades\Route;

// Route pour récupérer les vols d'une compagnie spécifique
Route::get('compagnies/{compagnie}/vols', function (Compagnie $compagnie) {
    return $compagnie->vols;  // Récupère tous les vols de la compagnie
});
