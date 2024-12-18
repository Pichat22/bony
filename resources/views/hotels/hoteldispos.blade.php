@extends('layouts.app')

@section('content')

<style>
    /* Conteneur pour la pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
        overflow-x: auto; /* Défilement horizontal si nécessaire */
        white-space: nowrap;
        visibility: hidden; /* Empêche les éléments de pagination de passer à la ligne */
    }

    /* Styles pour la pagination */
    .pagination a, .pagination span {
        display: inline-block;
        padding: 4px 8px; /* Réduit la taille du padding */
        font-size: 12px; /* Taille réduite des numéros et flèches */
        border: 1px solid #ddd;
        border-radius: 3px;
        color: #007bff;
        background-color: #fff;
        text-decoration: none;
        margin: 0 2px; /* Espacement réduit */
    }

    .pagination a:hover {
        background-color: #007bff;
        color: #fff;
    }

    .pagination .active span {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }
</style>

<div class="container my-5">
    <div class="card shadow-lg border-0">
        <!-- En-tête avec le titre -->
        <div class="card-header bg-gradient bg-warning text-white text-center">
            <h2 class="fw-bold mb-0">Hôtels Disponibles</h2>
        </div>

        <!-- Corps de la liste des hôtels -->
        <div class="card-body">
            @if ($hotels->count() > 0)
                <div class="row g-4">
                    @foreach ($hotels as $hotel)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <!-- Nom de l'hôtel -->
                                <div class="card-header bg-light">
                                    <h5 class="fw-bold text-center mb-0">{{ $hotel['name'] ?? 'Nom inconnu' }}</h5>
                                </div>

                                <!-- Détails de l'hôtel -->
                                <div class="card-body d-flex flex-column">
                                    <p>
                                        <i class="bi bi-geo-alt text-danger"></i>
                                        Latitude : <strong>{{ $hotel['geoCode']['latitude'] ?? 'N/A' }}</strong>
                                    </p>
                                    <p>
                                        <i class="bi bi-geo text-primary"></i>
                                        Longitude : <strong>{{ $hotel['geoCode']['longitude'] ?? 'N/A' }}</strong>
                                    </p>
                                    <p>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        Étoiles : <span class="fw-bold">{{ $hotel['rating'] ?? 'Non spécifié' }}</span>
                                    </p>
                                    @if (isset($hotel['price']['total']))
                                        <p>
                                            <i class="bi bi-currency-euro text-success"></i>
                                            Prix : 
                                            <span class="fw-bold text-success fs-5">
                                                {{ number_format($hotel['price']['total'], 2, ',', ' ') }} €
                                            </span>
                                        </p>
                                    @else
                                        <p>
                                            <i class="bi bi-currency-euro text-secondary"></i>
                                            Prix : <span class="text-muted">Non disponible</span>
                                        </p>
                                    @endif
                                </div>

                                <!-- Bouton Réserver -->
                                <div class="card-footer bg-white text-center">
                                    <a href="{{ route('reservations.create.hotel', ['hotel' => json_encode($hotel)]) }}" 
                                        class="btn btn-warning btn-sm fw-bold text-white">
                                         <i class="bi bi-cart-fill"></i> Réserver
                                     </a>
                                     
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-container mt-4">
                    {{ $hotels->links() }}
                </div>
            @else
                <!-- Aucun hôtel trouvé -->
                <p class="text-danger text-center fs-4">Aucun hôtel trouvé.</p>
            @endif
        </div>
    </div>
</div>
@endsection
