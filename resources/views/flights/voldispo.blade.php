@extends('layouts.app')

@section('content')
    <h1 class="mb-4 text-center">Vols disponibles</h1>

    @if ($flights->count() > 0)
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Compagnie</th>
                    <th>Origine</th>
                    <th>Destination</th>
                    <th>Heure de départ</th>
                    <th>Heure d'arrivée</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($flights as $flight)
                    @foreach ($flight['itineraries'] as $itinerary)
                        @foreach ($itinerary['segments'] as $segment)
                            <tr>
                                <td>{{ $flight['airlineName'] ?? $flight['validatingAirlineCodes'][0] }}</td>
                                <td>{{ $segment['departure']['cityName'] ?? $segment['departure']['iataCode'] }}</td>
                                <td>{{ $segment['arrival']['cityName'] ?? $segment['arrival']['iataCode'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($segment['departure']['at'])->format('d/m/Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($segment['arrival']['at'])->format('d/m/Y H:i') }}</td>
                                <td>{{ $flight['price']['total'] }} {{ $flight['price']['currency'] }}</td>
                                <td>
                                    <a href="{{ route('reservations.create', ['flight' => json_encode($flight)]) }}" 
                                       class="btn btn-primary btn-sm">Réserver</a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $flights->appends(request()->query())->links() }}
        </div>
    @else
        <p class="text-center">Aucun vol disponible.</p>
    @endif
@endsection
