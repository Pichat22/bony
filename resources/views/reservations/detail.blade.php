@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center text-primary">Liste des Réservations</h1>

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tableau des réservations -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">Réservations</h5>
        </div>
        <div class="card-body">
            @if ($reservations->count() > 0)
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Compagnie / Hôtel</th>
                            <th>Origine / Ville</th>
                            <th>Destination / Check-Out</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Prix</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>
                                {{ $reservation->type_reservation === 'billet' ? 'Billet d\'avion' : 'Hôtel' }}
                            </td>
                            <td>
                                {{ $reservation->compagnie ?? $reservation->nom_hotel }}
                            </td>
                            <td>
                                {{ $reservation->origine ?? $reservation->ville_hotel }}
                            </td>
                            <td>
                                {{ $reservation->destination ?? \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                            </td>
                            <td>
                                <span class="badge 
                                    {{ $reservation->statut === 'confirmée' ? 'bg-success' : ($reservation->statut === 'annulée' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ ucfirst($reservation->statut) }}
                                </span>
                            </td>
                            <td>{{ number_format($reservation->prix, 2, ',', ' ') }} €</td>
                            <td class="text-center">
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-muted">Aucune réservation trouvée.</p>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $reservations->links() }}
    </div>
</div>
@endsection
