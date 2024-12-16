@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center text-primary mb-4">Tableau de Bord</h1>

    <!-- Cartes statistiques -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        <div class="col">
            <div class="card text-white shadow-lg h-100" style="background-color: #4CAF50;">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Total Réservations</h5>
                    <p class="display-4">{{ $totalReservations }}</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white shadow-lg h-100" style="background-color: #2196F3;">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Trajets Réservés</h5>
                    <p class="display-4">{{ $trajects->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white shadow-lg h-100" style="background-color: #FF9800;">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Compagnies Réservées</h5>
                    <p class="display-4">{{ $compagnies->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sections de données -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Trajets Réservés</h5>
                </div>
                <div class="card-body">
                    @if ($trajects->isEmpty())
                        <p class="text-muted text-center">Aucun trajet réservé pour le moment.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($trajects as $trajet)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $trajet->origine }} → {{ $trajet->destination }}
                                    <span class="badge bg-primary rounded-pill">Trajet</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-lg h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Compagnies Réservées</h5>
                </div>
                <div class="card-body">
                    @if ($compagnies->isEmpty())
                        <p class="text-muted text-center">Aucune réservation de compagnie pour le moment.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($compagnies as $compagnie)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $compagnie->compagnie }}
                                    <span class="badge bg-success rounded-pill">{{ $compagnie->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique -->
    <div class="card shadow-lg mt-5">
        <div class="card-header bg-dark text-white">
            <h5>Réservations par Mois</h5>
        </div>
        <div class="card-body">
            <canvas id="reservationsByMonthChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('reservationsByMonthChart').getContext('2d');
    const data = @json($reservationsByMonth);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(data),
            datasets: [{
                label: 'Nombre de Réservations',
                data: Object.values(data),
                backgroundColor: [
                    '#4CAF50', '#2196F3', '#FF9800', '#9C27B0', '#00BCD4',
                    '#E91E63', '#3F51B5', '#8BC34A', '#FFC107', '#795548',
                    '#607D8B', '#FF5722'
                ],
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
