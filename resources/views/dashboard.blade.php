@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4 text-uppercase text-primary">Tableau de Bord</h1>

    <!-- Message de succès -->
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <!-- Actions -->
    <div class="d-flex justify-content-between mb-4">
              <!-- affocher user conceter  -->
            
        <div>
            <a href="{{ route('hotels.search.form') }}" class="btn btn-warning text-white">
                <i class="bi bi-search"></i> Rechercher un Hôtel
            </a>
            <a href="{{ route('flights.search') }}" class="btn btn-info text-white">
                <i class="bi bi-search"></i> Rechercher un Billet
            </a>
        </div>
    </div>

    <!-- Réservations d'Hôtels -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-warning text-white">
            <h2 class="mb-0">Réservations d'Hôtels</h2>
        </div>
        <div class="card-body">
            @if ($hotelReservations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-warning text-white">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Nom Hôtel</th>
                                <th>Ville</th>
                                <th>Prix</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hotelReservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                                    <td>{{ $reservation->nom_hotel }}</td>
                                    <td>{{ $reservation->ville_hotel }}</td>
                                    <td>{{ number_format($reservation->prix, 2, ',', ' ') }} €</td>
                                    <td>
                                        <span class="badge 
                                            {{ $reservation->statut === 'confirmée' ? 'bg-success' : ($reservation->statut === 'annulée' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ ucfirst($reservation->statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-success btn-sm">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Aucune réservation d'hôtel trouvée.</p>
            @endif
        </div>
    </div>

    <!-- Réservations de Billets -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Réservations de Billets</h2>
        </div>
        <div class="card-body">
            @if ($flightReservations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Compagnie</th>
                                <th>Origine</th>
                                <th>Destination</th>
                                <th>Départ</th>
                                <th>Arrivée</th>
                                <th>Prix</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($flightReservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                                    <td>{{ $reservation->compagnie }}</td>
                                    <td>{{ $reservation->origine }}</td>
                                    <td>{{ $reservation->destination }}</td>
                                    <td class="text-center">
                                        {{ $reservation->heure_depart ? \Carbon\Carbon::parse($reservation->heure_depart)->format('H:i - d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $reservation->heure_arrivee ? \Carbon\Carbon::parse($reservation->heure_arrivee)->format('H:i - d/m/Y') : 'N/A' }}
                                    </td>
                                    <td>{{ number_format($reservation->prix, 2, ',', ' ') }} €</td>
                                    <td>
                                        <span class="badge 
                                            {{ $reservation->statut === 'confirmée' ? 'bg-success' : ($reservation->statut === 'annulée' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ ucfirst($reservation->statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-success btn-sm">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Aucune réservation de billet trouvée.</p>
            @endif
        </div>
    </div>
</div>
@endsection
