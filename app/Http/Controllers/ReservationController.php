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
        $user=Auth::user();
        if($user->role==='client'){
            $reservations=Reservation::where('user_id',$user->id)->get();
        }
        
        if($user->role==='admin'){
        $reservations = Reservation::all();

        }
        return view('reservations.index',compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $reservation = Reservations::all();
        return view('reservations.form', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_de_place' => 'required|integer',
            'classe' => 'required|in:Économique,Business,Première',
            'passengers' => 'required|array|min:1',
            'passengers.*.nom_personne' => 'required|string|max:255',
            'passengers.*.prenom_personne' => 'required|string|max:255',
            'passengers.*.telephone_personne' => 'required|string|max:15',
            'passengers.*.numero_identite_personne' => 'required|string|max:20',
        ]);
    
        foreach ($request->passengers as $passenger) {
            Reservation::create([
                'user_id' => Auth::id(),
                'nombre_de_place' => 1, // Chaque réservation est pour une personne
                'date' => now(),
                'statut' => 'confirmée',
                'classe' => $request->classe,
                'nom_personne' => $passenger['nom_personne'],
                'prenom_personne' => $passenger['prenom_personne'],
                'telephone_personne' => $passenger['telephone_personne'],
                'numero_identite_personne' => $passenger['numero_identite_personne'],
            ]);
        }
    
        return redirect()->route('reservations.index')->with('success', 'Réservations créées avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation = Reservation::with(['user'])->findOrFail($id);
        
        return view('reservations.detail',compact('reservation'));
        
    }

    public function ReservationByUser(){

        $reservation = Reservation::with('user')->get()->groupBy('user_id');
        
        return view('reservation.user', compact('reservation'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
              return view('reservations.edit',compact('reservation', 'villes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index');
    }
    public function storeHotel(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'date' => 'required',
            'nombre_de_place' => 'required|integer|min:1',
            'nom_personne' => 'required|string|max:255',
            'prenom_personne' => 'required|string|max:255',
            'telephone_personne' => 'required|string|max:15',
            'numero_identite_personne' => 'required|string|max:20',
        ]);
    
        Reservation::create([
            'user_id' => Auth::id(),
            'hotel_id' => $request->hotel_id,
            'date' => $request->date,
            'statut' => 'confirmée',
            'nombre_de_place' => $request->nombre_de_place,
            'nom_personne' => $request->nom_personne,
            'prenom_personne' => $request->prenom_personne,
            'telephone_personne' => $request->telephone_personne,
            'numero_identite_personne' => $request->numero_identite_personne,
        ]);
    
        return redirect()->route('reservations.index')->with('success', 'Réservation d\'hôtel créée avec succès.');
    }
    public function downloadPDF($id)
    {
    
        $pdf = \PDF::loadView('reservations.pdf', compact('reservation'));
    
        return $pdf->download('reservation-details.pdf');
    }
}
