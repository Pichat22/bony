@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center text-warning mb-4">Tableau de Bord</h1>
    <h4 class="text-center text-secondary mb-5">Réservations faites par <span class="fw-bold text-dark">{{ Auth::user()->name }}</span></h4>

    <h3 class="mb-4 text-secondary">Vos Réservations</h3>
    <div class="card shadow-lg border-0">
        <div class="card-header bg-warning text-white">
            <h4 class="text-center">Détail de vos Réservations</h4>
        </div>
        <div class="card-body">
            @if ($userReservations->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    <strong>Pas de réservations trouvées.</strong> Vous n'avez effectué aucune réservation pour le moment.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Compagnie</th>
                                <th>Origine</th>
                                <th>Destination</th>
                                <th>Date de Départ</th>
                                <th>Date d'Arrivée</th>
                                <th>Prix (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userReservations as $reservation)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $reservation->compagnie }}</td>
                                    <td class="align-middle">{{ $reservation->origine }}</td>
                                    <td class="align-middle">{{ $reservation->destination }}</td>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($reservation->heure_depart)->format('d/m/Y H:i') }}</td>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($reservation->heure_arrivee)->format('d/m/Y H:i') }}</td>
                                    <td class="align-middle text-success fw-bold">{{ number_format($reservation->prix, 2, ',', ' ') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="card-footer bg-light text-center">
            <a href="{{ route('flights.search') }}" class="btn btn-warning btn-lg">
                <i class="bi bi-plus-circle"></i> Faire une Nouvelle Réservation
            </a>
        </div>
    </div>
</div>
@endsection
