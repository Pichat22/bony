<h1>Liste des Vols</h1>
<ul>
    @foreach ($flights['data'] as $flight)
        <li>
            De {{ $flight['itineraries'][0]['segments'][0]['departure']['iataCode'] }}
            à {{ $flight['itineraries'][0]['segments'][0]['arrival']['iataCode'] }}
            - {{ $flight['price']['total'] }} EUR
        </li>
    @endforeach
</ul>
