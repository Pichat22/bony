@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center text-primary mb-4">Réservations des Clients</h1>

    <div class="card shadow-lg mb-5">
        <div class="card-header bg-warning text-white">
            <h3 class="text-center mb-0">Réservations d'Hôtels</h3>
        </div>
        <div class="card-body">
            @if ($hotelReservations->isEmpty())
                <p class="text-center text-muted">Aucune réservation d'hôtel trouvée.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="bg-warning text-white">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Nom Hôtel</th>
                                <th>Ville</th>
                                <th>Arrivée</th>
                                <th>Départ</th>
                                <th>Prix (€)</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hotelReservations as $reservation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reservation->user->nom ?? 'Utilisateur supprimé' }}</td>
                                    <td>{{ $reservation->nom_hotel }}</td>
                                    <td>{{ $reservation->ville_hotel }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</td>
                                    <td>{{ number_format($reservation->prix, 2, ',', ' ') }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $reservation->statut === 'confirmée' ? 'bg-success' : ($reservation->statut === 'annulée' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ ucfirst($reservation->statut) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h3 class="text-center mb-0">Réservations de Billets</h3>
        </div>
        <div class="card-body">
            @if ($flightReservations->isEmpty())
                <p class="text-center text-muted">Aucune réservation de billet trouvée.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="bg-success text-white">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Compagnie</th>
                                <th>Origine</th>
                                <th>Destination</th>
                                <th>Départ</th>
                                <th>Arrivée</th>
                                <th>Prix (€)</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($flightReservations as $reservation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reservation->user->nom ?? 'Utilisateur supprimé' }}</td>
                                    <td>{{ $reservation->compagnie }}</td>
                                    <td>{{ $reservation->origine }}</td>
                                    <td>{{ $reservation->destination }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->heure_depart)->format('H:i - d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->heure_arrivee)->format('H:i - d/m/Y') }}</td>
                                    <td>{{ number_format($reservation->prix, 2, ',', ' ') }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $reservation->statut === 'confirmée' ? 'bg-success' : ($reservation->statut === 'annulée' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ ucfirst($reservation->statut) }}
                                        </span>
                                    </td>
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
