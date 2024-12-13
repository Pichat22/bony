<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    
        return redirect()->route('reservations.index')->with('message', 'Réservations créées avec succès.');
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
    
        return redirect()->route('reservations.index')->with('message', 'Réservations modifiées avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index');
    }
   
}
