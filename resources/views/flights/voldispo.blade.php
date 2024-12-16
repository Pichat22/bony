@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white text-center">
            <h1 class="mb-0">Vols Disponibles</h1>
        </div>
        <div class="card-body">
            @if ($flights->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Compagnie</th>
                                <th>Origine</th>
                                <th>Destination</th>
                                <th class="text-center">Heure de départ</th>
                                <th class="text-center">Heure d'arrivée</th>
                                <th class="text-center">Prix</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($flights as $flight)
                                @foreach ($flight['itineraries'] as $itinerary)
                                    @foreach ($itinerary['segments'] as $segment)
                                        <tr>
                                            <td class="align-middle">{{ $flight['airlineName'] ?? $flight['validatingAirlineCodes'][0] }}</td>
                                            <td class="align-middle">{{ $segment['departure']['cityName'] ?? $segment['departure']['iataCode'] }}</td>
                                            <td class="align-middle">{{ $segment['arrival']['cityName'] ?? $segment['arrival']['iataCode'] }}</td>
                                            <td class="text-center align-middle text-primary">
                                                {{ \Carbon\Carbon::parse($segment['departure']['at'])->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="text-center align-middle text-success">
                                                {{ \Carbon\Carbon::parse($segment['arrival']['at'])->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="text-center align-middle text-danger">
                                                {{ number_format($flight['price']['total'], 2, ',', ' ') }} {{ $flight['price']['currency'] }}
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('reservations.create', ['flight' => json_encode($flight)]) }}" 
                                                   class="btn btn-warning btn-sm text-white">
                                                    Réserver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $flights->appends(request()->query())->links() }}
                </div>
            @else
                <p class="text-center text-danger">Aucun vol disponible.</p>
            @endif
        </div>
    </div>
</div>
@endsection
