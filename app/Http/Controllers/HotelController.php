<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'ville_id' => 'required|exists:villes,id',
    
            
    
    
           ]);
           
           Hotel::create($request->all());
    
           
           return redirect()->route('hotels.index')->with('success', 'hotel enregistré avec succès');
    
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
        
        $villes = Ville::all(); // Pour permettre la sélection des villes de départ et d'arrivée

        return view('hotels.edit',compact('hotel', 'villes'));
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
            'ville_id' => 'required|exists:villes,id',
    
            
    
    
           ]);
           
           $hotel->update($request->all());
    
           
           return redirect()->route('hotels.index')->with('success', 'hotel modifié avec succès');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete(); 
        return redirect()->route('hotels.index');
    }
}
