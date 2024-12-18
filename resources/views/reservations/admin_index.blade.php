@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center text-primary mb-4">Toutes les Réservations</h1>

    <div class="card shadow-lg">
        <div class="card-body">
            @if ($reservations->isEmpty())
                <p class="text-center">Aucune réservation trouvée.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Utilisateur</th>
                                <th>Compagnie</th>
                                <th>Origine</th>
                                <th>Destination</th>
                                <th>Départ</th>
                                <th>Arrivée</th>
                                <th>Prix (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reservation->user->nom ?? 'Utilisateur supprimé' }}</td>
                                    <td>{{ $reservation->compagnie }}</td>
                                    <td>{{ $reservation->origine }}</td>
                                    <td>{{ $reservation->destination }}</td>
                                    <td>{{ $reservation->heure_depart }}</td>
                                    <td>{{ $reservation->heure_arrivee }}</td>
                                    <td>{{ $reservation->prix }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
