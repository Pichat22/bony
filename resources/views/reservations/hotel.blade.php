@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white text-center">
            <h2>Réservation d'Hôtel</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('reservations.store.hotel') }}" class="needs-validation" novalidate>
                @csrf

                <!-- Informations de l'hôtel -->
                <div class="mb-4">
                    <h4 class="text-primary">Informations de l'Hôtel</h4>
                    <div class="form-group">
                        <label>Nom de l'Hôtel</label>
                        <input type="text" class="form-control" name="nom_hotel" value="{{ $hotel['name'] }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Ville</label>
                        <input type="text" class="form-control" name="ville_hotel" value="{{ $hotel['address']['cityName'] ?? 'Non spécifiée' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Prix (par nuit)</label>
                        <input type="text" class="form-control" name="prix" value="{{ $hotel['price']['total'] ?? '0.00' }}" readonly>
                    </div>
                </div>

                <!-- Dates de réservation -->
                <div class="mb-4">
                    <h4 class="text-primary">Dates de Réservation</h4>
                    <div class="form-group">
                        <label>Date d'Arrivée</label>
                        <input type="date" class="form-control" name="date_arrivee" required>
                    </div>
                    <div class="form-group">
                        <label>Date de Départ</label>
                        <input type="date" class="form-control" name="date_depart" required>
                    </div>
                </div>

                <!-- Informations du client -->
                <div class="mb-4">
                    <h4 class="text-primary">Informations du Client</h4>
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" class="form-control" name="client[nom]" placeholder="Nom du client" required>
                    </div>
                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" class="form-control" name="client[prenom]" placeholder="Prénom du client" required>
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" class="form-control" name="client[telephone]" placeholder="Téléphone du client" required>
                    </div>
                </div>

                <!-- Nombre de chambres -->
                <div class="mb-4">
                    <h4 class="text-primary">Nombre de Chambres</h4>
                    <div class="form-group">
                        <input type="number" class="form-control" name="nombre_chambres" placeholder="Nombre de chambres" min="1" required>
                    </div>
                </div>

                <!-- Bouton Soumettre -->
                <div class="text-center">
                    <button type="submit" class="btn btn-warning btn-lg">Réserver</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
