<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la réservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
        }
        .details {
            margin-top: 20px;
        }
        .escales {
            margin-top: 10px;
        }
        .escales ul {
            list-style-type: none;
            padding: 0;
        }
        .escales ul li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Détails de la réservation</h1>
    </div>
    <div class="details">
        <p><strong>Nom du passager :</strong> {{ $reservation->nom_personne }}</p>
        <p><strong>Prénom du passager :</strong> {{ $reservation->prenom_personne }}</p>
        <p><strong>Téléphone :</strong> {{ $reservation->telephone_personne }}</p>
        <p><strong>Numéro d'identité :</strong> {{ $reservation->numero_identite_personne }}</p>
        <p><strong>Classe :</strong> {{ $reservation->classe }}</p>
        <p><strong>Trajet :</strong> {{ $reservation->trajet->villeDepart->nom }} à {{ $reservation->trajet->villeArrivee->nom }}</p>
        <p><strong>Compagnie :</strong> {{ $reservation->trajet->compagnie->nom_compagnie }}</p>
        <p><strong>Vol :</strong> {{ $reservation->trajet->vol->matricule }}</p>
        <p><strong>Date de départ :</strong> {{ $reservation->trajet->date_depart }}</p>
        <p><strong>Durée estimée du vol :</strong> {{ $reservation->trajet->duree }}</p>
        <p><strong>Statut :</strong> {{ $reservation->statut }}</p>

        <div class="escales">
            <h3>Echelles :</h3>
            @if($reservation->trajet->escales->isEmpty())
                <p>Aucune escale</p>
            @else
                <ul>
                    @foreach($reservation->trajet->escales as $escale)
                        <li>
                            <strong>Ville :</strong> {{ $escale->ville->nom }} ({{ $escale->ordre }}e escale)
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</body>
</html>
