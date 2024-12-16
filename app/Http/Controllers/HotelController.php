<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Services\AmadeusService;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels= hotel::all();
        return view('hotels.index',compact('hotels'));
    }
    public function __construct(AmadeusService $amadeusService)
    {
        $this->amadeusService = $amadeusService;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $villes = Ville::all(); // Pour permettre la sélection des villes de départ et d'arrivée

        return view('hotels.form');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'=>'required',
            'adresse'=>'required',
            'etoil'=>'required',
            'prix'=>'required',
            'ville' => 'required',
    
            
    
    
           ]);
           
           Hotel::create($request->all());
    
           
           return redirect()->route('hotels.index')->with('message', 'hotel enregistré avec succès');
    
    } public function searchCities(Request $request, AmadeusService $amadeusService)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json(['error' => 'Le champ de recherche est vide.'], 400);
        }

        try {
            $results = $amadeusService->searchCities($query); // Requête vers l'API Amadeus

            if (isset($results['errors'])) {
                return response()->json(['error' => $results['errors'][0]['detail'] ?? 'Erreur API'], 400);
            }

            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur serveur : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        return view('hotels.detail',compact('hotel'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        
        // $villes = Ville::all(); // Pour permettre la sélection des villes de départ et d'arrivée

        return view('hotels.edit',compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'nom'=>'required',
            'adresse'=>'required',
            'etoil'=>'required',
            'prix'=>'required',
            'ville' => 'required',
    
            
    
    
           ]);
           
           $hotel->update($request->all());
    
           
              return redirect()->route('hotels.index')->with('message', 'hotel modifié avec succès');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete(); 
        return redirect()->route('hotels.index')->with('message', 'hotel supprimé avec succès');
    }
   
    
//     public function searchForm()
//     {
//         $villes = Ville::all();
    
//         return view('hotels.search', compact('villes'));
// }



public function showHotelSearchForm()
{
    return view('hotels.search');
}

private $amadeusService;



public function searchHotels(Request $request, AmadeusService $amadeusService)
{
    // Validation des données de recherche
    $request->validate([
        'city_code' => 'required|string',
        'check_in_date' => 'required|date|after:today',
        'check_out_date' => 'required|date|after:check_in_date',
    ]);

    // Logs pour inspecter les données envoyées
    \Log::info('Search request data', $request->all());

    // Appel à l'API Amadeus
    $hotels = $amadeusService->searchHotels(
        $request->input('city_code'),
        $request->input('check_in_date'),
        $request->input('check_out_date')
    );

    // Gestion des erreurs retournées par Amadeus
    if (isset($hotels['error'])) {
        return back()->withErrors(['error' => $hotels['error']]);
    }

    return view('hotels.index', ['hotels' => $hotels['data'] ?? []]);
}








}