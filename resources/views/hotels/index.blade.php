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
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hotels as $hotel)
                                <tr>
                                    <td>{{ $hotel['name'] ?? 'Nom inconnu' }}</td>
                                    <td>{{ $hotel['geoCode']['latitude'] ?? 'N/A' }}</td>
                                    <td>{{ $hotel['geoCode']['longitude'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-danger text-center">Aucun hôtel trouvé.</p>
            @endif
        </div>
    </div>
</div>
@endsection
