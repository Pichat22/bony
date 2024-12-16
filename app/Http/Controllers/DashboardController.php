<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer le nombre total de réservations
        $totalReservations = Reservation::count();

        // Récupérer les trajets réservés
        $trajects = Reservation::select('origine', 'destination')
            ->distinct()
            ->get();

        // Récupérer les compagnies réservées et le nombre de réservations par compagnie
        $compagnies = Reservation::select('compagnie')
            ->groupBy('compagnie')
            ->selectRaw('compagnie, COUNT(*) as total')
            ->orderBy('total', 'desc')
            ->get();

        // Statistiques supplémentaires (par exemple, réservations par mois)
        $reservationsByMonth = Reservation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [date('F', mktime(0, 0, 0, $item->month, 1)) => $item->total];
            });

        return view('dashboard.index', compact(
            'totalReservations',
            'trajects',
            'compagnies',
            'reservationsByMonth'
        ));
    }
    
}
