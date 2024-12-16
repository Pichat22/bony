<?php

namespace App\Http\Controllers;

use App\Models\Reservation;

use Illuminate\Support\Facades\Auth;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\AmadeusService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Http;
class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations= Reservation::all();
        return view('reservations.index',compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reservations.form');
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date'=>'required',
            'statut'=>'required',
            'classe'=>'required',
    
           ]);
           
           Reservation::create([
            'user_id' => Auth::id(), // ID de l'utilisateur connecté
            'date' => $request->date,
            'statut' => $request->statut,
            'classe' => $request->classe,
        ]);
    
        return redirect()->route('reservations.index')->with('success', 'Réservations créées avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        
        return view('reservations.detail',compact('reservation'));
        
    }

    // public function ReservationByUser(){

    //     $reservation = Reservation::with('user')->get()->groupBy('user_id');
        
    //     return view('reservation.user', compact('reservation'));
        
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        return view('reservations.edit',compact('reservation'));
              
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'date'=>'required',
            'statut'=>'required',
            'classe'=>'required',
    
           ]);
           
           $reservation->update([
            'date' => $request->date,
            'statut' => $request->statut,
            'classe' => $request->classe,
        ]);
    
        return redirect()->route('reservations.index')->with('success', 'Réservations modifiées avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index');
    }
    
    protected $amadeusService;

    public function __construct(AmadeusService $amadeusService)
    {
        $this->amadeusService = $amadeusService;
    }

    public function showSearchForm()
    {
        return view('flights.search');
    }

    public function searchFlights(Request $request)
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $departureDate = $request->input('departureDate');

        $flights = $this->amadeusService->searchFlights($origin, $destination, $departureDate);

        return view('flights.search', compact('flights'));
    }
    public function searchHotels(Request $request)
    {
        $query = $request->input('query');

        $hotels = $this->amadeusService->searchCities($query);

        return response()->json($hotels);
    }
    public function searchCities(Request $request, AmadeusService $amadeusService)
{
    $query = $request->input('query');

    if (empty($query)) {
        return response()->json(['error' => 'Le champ de recherche est vide.'], 400);
    }

    try {
        $results = $amadeusService->searchCities($query);

        if (isset($results['errors'])) {
            return response()->json(['error' => $results['errors'][0]['detail'] ?? 'Erreur API'], 400);
        }

        return response()->json($results);
    } catch (Exception $e) {
        return response()->json(['error' => 'Erreur serveur : ' . $e->getMessage()], 500);
    }
}

public function search(Request $request, AmadeusService $amadeusService)
{
    $flights = $amadeusService->searchFlights(
        $request->input('ville_depart'),
        $request->input('ville_arrivee'),
        $request->input('date_depart')
    );

    if (!empty($flights['data'])) {
        foreach ($flights['data'] as &$flight) {
            $airlineCode = $flight['validatingAirlineCodes'][0] ?? null;

            if ($airlineCode) {
                $flight['airlineName'] = $amadeusService->getAirlineName($airlineCode);
            }

            foreach ($flight['itineraries'] as &$itinerary) {
                foreach ($itinerary['segments'] as &$segment) {
                    $segment['departure']['cityName'] = $amadeusService->getCityFromIata($segment['departure']['iataCode']);
                    $segment['arrival']['cityName'] = $amadeusService->getCityFromIata($segment['arrival']['iataCode']);
                }
            }
        }
    }

    // Convertir les données en collection
    $flightsCollection = collect($flights['data']);

    // Paginer la collection
    $perPage = 6; // Nombre d'éléments par page
    $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Page actuelle
    $currentItems = $flightsCollection->slice(($currentPage - 1) * $perPage, $perPage)->values(); // Découpe les éléments pour la page

    $paginatedFlights = new LengthAwarePaginator(
        $currentItems, // Les éléments de la page
        $flightsCollection->count(), // Total des éléments
        $perPage, // Nombre par page
        $currentPage, // Page actuelle
        ['path' => LengthAwarePaginator::resolveCurrentPath()] // Chemin de pagination
    );

    return view('flights.voldispo', [
        'flights' => $paginatedFlights, // Données paginées
    ]);
}







}
