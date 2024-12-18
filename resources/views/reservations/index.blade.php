@extends('layouts.app')
@section('content')
<div class="card mt-3 shadow-lg p-3 mb-5 rounded">
    <div class="card-header bg-warning">
        <h1 class="text-center text-white">Liste des Réservations</h1>
    </div>
    <div class="card-body">
        <a href="{{ route('reservations.create') }}" class="btn btn-warning text-light mb-3">Ajouter Réservation</a>

        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <!-- Conteneur avec défilement horizontal -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="bg-warning text-white">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Type de Réservation</th>
                        <th>Compagnie / Hôtel</th>
                        <th>Origine</th>
                        <th>Destination</th>
                        <th class="text-center">Départ</th>
                        <th class="text-center">Arrivée</th>
                        <th class="text-center">Prix</th>
                        <th>Statut</th>
                        <th>Classe</th>
                        {{-- <th class="text-center">Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($reservation->type_reservation) }}</td>
                            <td>{{ $reservation->compagnie ?? $reservation->nom_hotel }}</td>
                            <td>{{ $reservation->origine ?? $reservation->ville_hotel }}</td>
                            <td>{{ $reservation->destination ?? 'N/A' }}</td>
                            <td class="text-center text-primary">
                                {{ $reservation->heure_depart ? \Carbon\Carbon::parse($reservation->heure_depart)->format('H:i - d/m/Y') : 'N/A' }}
                            </td>
                            <td class="text-center text-success">
                                {{ $reservation->heure_arrivee ? \Carbon\Carbon::parse($reservation->heure_arrivee)->format('H:i - d/m/Y') : 'N/A' }}
                            </td>
                            <td class="text-center text-danger">
                                {{ number_format($reservation->prix, 2, ',', ' ') }} €
                            </td>
                            <td>
                                <span class="badge 
                                    {{ $reservation->statut === 'confirmée' ? 'bg-success' : ($reservation->statut === 'annulée' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ ucfirst($reservation->statut) }}
                                </span>
                            </td>
                            <td>{{ $reservation->classe ?? 'N/A' }}</td>
                            {{-- <td class="d-flex justify-content-center">
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-success btn-sm m-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-warning btn-sm m-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="m-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ?')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection
