<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Services\AmadeusService;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
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
    $request->validate([
        'city_code' => 'required|string',
    ]);

    // Log pour débogage
    \Log::info('Search request data', $request->all());

    $hotels = $amadeusService->searchHotels($request->input('city_code'));

    // Gestion des erreurs
    if (isset($hotels['error'])) {
        return back()->withErrors(['error' => $hotels['error']]);
    }

    if (empty($hotels['data'])) {
        return back()->withErrors(['error' => 'Aucun hôtel trouvé pour cette ville.']);
    }

    // Pagination des résultats
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 8; // Nombre d'hôtels par page
    $hotelsCollection = collect($hotels['data']);
    $currentPageItems = $hotelsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

    $paginatedHotels = new LengthAwarePaginator(
        $currentPageItems,
        $hotelsCollection->count(),
        $perPage,
        $currentPage,
        ['path' => LengthAwarePaginator::resolveCurrentPath()]
    );

    return view('hotels.hoteldispos', ['hotels' => $paginatedHotels]);
}





}