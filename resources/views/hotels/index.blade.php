@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white text-center">
            <h2>Hôtels Disponibles</h2>
        </div>
        <div class="card-body">
            @if (count($hotels) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-success text-white">
                            <tr>
                                <th>Hôtel</th>
                                <th>Adresse</th>
                                <th>Prix (par nuit)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hotels as $hotel)
                                <tr>
                                    <td>{{ $hotel['hotel']['name'] ?? 'Non spécifié' }}</td>
                                    <td>{{ $hotel['hotel']['address']['lines'][0] ?? 'Adresse non disponible' }}</td>
                                    <td class="text-danger">
                                        {{ number_format($hotel['offers'][0]['price']['total'], 2, ',', ' ') }} €
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('reservations.create.hotel', ['hotel' => json_encode($hotel)]) }}" 
                                           class="btn btn-warning btn-sm text-white">
                                            Réserver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-danger">Aucun hôtel disponible.</p>
            @endif
        </div>
    </div>
</div>
@endsection
