<?php

namespace App\Http\Controllers;

use App\Models\Reservation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Collection;
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
       
    $reservations = Reservation::paginate(10); // 10 réservations par page
    return view('reservations.index', compact('reservations'));
    }

    //reservation par utilisateur connecté
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $flight = json_decode($request->input('flight'), true);

        // Vérifiez les données pour éviter les erreurs
        $origin = $flight['itineraries'][0]['segments'][0]['departure']['cityName'] ?? 'Non spécifiée';
        $destination = $flight['itineraries'][0]['segments'][0]['arrival']['cityName'] ?? 'Non spécifiée';
        $price = $flight['price']['total'] ?? 0;
        $currency = $flight['price']['currency'] ?? 'EUR';
    
        return view('reservations.form', compact('flight', 'origin', 'destination', 'price', 'currency'));
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'compagnie' => 'required|string',
            'origine' => 'required|string',
            'destination' => 'required|string',
            'heure_depart' => 'required|date', // Assurez-vous qu'il s'agit d'une date valide
            'heure_arrivee' => 'required|date|after_or_equal:heure_depart',
            'prix' => 'required|numeric|min:0', // Prix doit être un nombre valide
            'nombre_passagers' => 'required|integer|min:1',
            'passagers' => 'required|array',
            'passagers.*.nom' => 'required|string|max:255',
            'passagers.*.prenom' => 'required|string|max:255',
            'passagers.*.telephone' => 'required|string|max:20',
        ]);
    
        // Reformater les dates si nécessaire
        $heure_depart = \Carbon\Carbon::parse($request->input('heure_depart'))->format('Y-m-d H:i:s');
        $heure_arrivee = \Carbon\Carbon::parse($request->input('heure_arrivee'))->format('Y-m-d H:i:s');
    
        // Préparer les passagers
        $passagers = [];
        foreach ($request->input('passagers') as $passager) {
            $passagers[] = [
                'nom' => $passager['nom'],
                'prenom' => $passager['prenom'],
                'telephone' => $passager['telephone'],
            ];
        }
    
        // Enregistrer la réservation
        Reservation::create([
            'type_reservation' => 'billet',
            'date' => now(),
            'statut' => 'en attente',
            'user_id' => auth()->id(),
            'compagnie' => $request->input('compagnie'),
            'origine' => $request->input('origine'),
            'destination' => $request->input('destination'),
            'heure_depart' => $heure_depart,
            'heure_arrivee' => $heure_arrivee,
            'prix' => $request->input('prix'),
            'nombre_places' => $request->input('nombre_passagers'),
            'passagers' => json_encode($passagers),
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Réservation enregistrée avec succès.');
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
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $currentItems = $flightsCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();

    $paginatedFlights = new LengthAwarePaginator(
        $currentItems, // Les éléments de la page
        $flightsCollection->count(), // Total des éléments
        $perPage, // Nombre par page
        $currentPage, // Page actuelle
        ['path' => request()->url(), 'query' => request()->query()] // Chemin et paramètres pour la pagination
    );

    return view('flights.voldispo', [
        'flights' => $paginatedFlights, // Retourne un objet LengthAwarePaginator
    ]);
}



public function indexAdmin()
    {
        // Récupérer toutes les réservations avec leurs utilisateurs
        $reservations = Reservation::with('user')->get();

        return view('reservations.admin_index', compact('reservations'));
    }





}
