@extends('layouts.app')

@section('content')
    <h1>Vols disponibles</h1>

    @if($trajets->isEmpty())
        <p>Aucun vol trouvé pour les critères sélectionnés.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ville de départ</th>
                    <th>Ville d'arrivée</th>
                    <th>Compagnie</th>
                    <th>Vol</th>
                    <th>Nombre de places disponibles</th>
                    <th>Date de départ</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trajets as $trajet)
                    <tr>
                        <td>{{ $trajet->villeDepart->nom }}</td>
                        <td>{{ $trajet->villeArrivee->nom }}</td>
                        <td>{{ $trajet->compagnie->nom_compagnie }}</td>
                        <td>{{ $trajet->vol->matricule }}</td>
                        <td>{{ $trajet->vol->placesDisponibles() }}</td>
                        <td>{{ $trajet->date_depart }}</td>
                        <td>
                            <form method="POST" action="{{ route('reservations.update') }}">
                                @csrf
                                <input type="hidden" name="trajet_id" value="{{ $trajet->id }}">
                                
                                <!-- Sélection de la classe -->
                                <select name="classe" class="form-control mb-2" required>
                                    <option value="" disabled selected>Choisissez une classe</option>
                                    <option value="Économique">Économique</option>
                                    <option value="Business">Business</option>
                                    <option value="Première">Première</option>
                                </select>
                                
                                <!-- Nombre de places -->
                                <input type="number" value="{{$reservation->nombre_de_place}}" name="nombre_de_place" id="nombre_de_place_{{ $trajet->id }}" min="1" class="form-control mb-2" placeholder="Nombre de places" required>
                                
                                <div id="passenger-info-container-{{ $trajet->id }}"></div> <!-- Conteneur pour les informations des passagers -->
                                
                                <button type="submit" class="btn btn-warning">Réserver</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('reservations.index') }}" class="btn btn-primary">Retour</a> 
<script>
    document.querySelectorAll('input[name="nombre_de_place"]').forEach(input => {
        input.addEventListener('input', function() {
            const numberOfPassengers = parseInt(this.value) || 0;
            const containerId = `passenger-info-container-${this.id.split('_').pop()}`;
            const container = document.getElementById(containerId);
            container.innerHTML = '';

            for (let i = 1; i <= numberOfPassengers; i++) {
                container.innerHTML += `
                    <h5>Informations pour le passager ${i}</h5>
                    <input type="text" name="passengers[${i}][nom_personne]" class="form-control mb-2" placeholder="Nom du passager ${i}" required>
                    <input type="text" name="passengers[${i}][prenom_personne]" class="form-control mb-2" placeholder="Prénom du passager ${i}" required>
                    <input type="text" name="passengers[${i}][telephone_personne]" class="form-control mb-2" placeholder="Téléphone du passager ${i}" required>
                    <input type="text" name="passengers[${i}][numero_identite_personne]" class="form-control mb-2" placeholder="Numéro d'identité du passager ${i}" required>
                `;
            }
        });
    });
</script>
@endsection
