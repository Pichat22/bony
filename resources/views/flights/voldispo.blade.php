@extends('layouts.app')

@section('content')
    <h1>Vols disponibles</h1>

    @if (!empty($flights['data']))
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Compagnie</th>
                <th>Origine</th>
                <th>Destination</th>
                <th>Heure de départ</th>
                <th>Heure d'arrivée</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($flights['data'] as $flight)
                @foreach ($flight['itineraries'] as $itinerary)
                    @foreach ($itinerary['segments'] as $segment)
                        <tr>
                            <td>{{ $flight['validatingAirlineCodes'][0] ?? 'N/A' }}</td>
                            <td>{{ $segment['departure']['cityName'] ?? $segment['departure']['iataCode'] }}</td>
                            <td>{{ $segment['arrival']['cityName'] ?? $segment['arrival']['iataCode'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($segment['departure']['at'])->format('d/m/Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($segment['arrival']['at'])->format('d/m/Y H:i') }}</td>
                            <td>{{ $flight['price']['total'] }} {{ $flight['price']['currency'] }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
    
    @else
        <p>Aucun vol disponible.</p>
    @endif
@endsection
