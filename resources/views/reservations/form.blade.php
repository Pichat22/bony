@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center text-warning">Formulaire de Réservation</h1>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire pour la réservation -->
        <form method="POST" action="{{ route('reservations.store') }}" class="needs-validation" novalidate>
            @csrf

            <!-- Carte principale pour les informations du vol -->
            <div class="card shadow-lg mb-5">
                <div class="card-header bg-warning text-white text-center">
                    <h5 class="text-uppercase mb-0">Informations du Vol</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold">Compagnie :</label>
                            <input type="text" class="form-control" name="compagnie" 
                                   value="{{ $flight['airlineName'] ?? ($flight['validatingAirlineCodes'][0] ?? 'Non spécifiée') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Prix :</label>
                            <input type="text" class="form-control" name="prix" 
                                   value="{{ number_format((float) $flight['price']['total'] ?? 0, 2, '.', '') }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold">Origine :</label>
                            <input type="text" class="form-control" name="origine" 
                                   value="{{ $flight['itineraries'][0]['segments'][0]['departure']['cityName'] ?? ($flight['itineraries'][0]['segments'][0]['departure']['iataCode'] ?? 'Non spécifiée') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Destination :</label>
                            <input type="text" class="form-control" name="destination" 
                                   value="{{ $flight['itineraries'][0]['segments'][0]['arrival']['cityName'] ?? ($flight['itineraries'][0]['segments'][0]['arrival']['iataCode'] ?? 'Non spécifiée') }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold">Heure de Départ :</label>
                            <input type="text" class="form-control" name="heure_depart" 
                                   value="{{ $flight['itineraries'][0]['segments'][0]['departure']['at'] ?? now()->toDateTimeString() }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Heure d'Arrivée :</label>
                            <input type="text" class="form-control" name="heure_arrivee" 
                                   value="{{ $flight['itineraries'][0]['segments'][0]['arrival']['at'] ?? now()->toDateTimeString() }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire pour les passagers -->
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-white text-center">
                    <h5 class="text-uppercase mb-0">Informations des Passagers</h5>
                </div>
                <div class="card-body">
                    <!-- Champ pour le nombre de passagers -->
                    <div class="form-group mb-4">
                        <label class="fw-bold">Nombre de Passagers :</label>
                        <input type="number" class="form-control" id="nombre_passagers" name="nombre_passagers" placeholder="Entrez le nombre de passagers" min="1" required>
                        <div class="invalid-feedback">
                            Veuillez entrer un nombre de passagers valide.
                        </div>
                    </div>

                    <!-- Conteneur des passagers -->
                    <div id="passengers-container" class="mt-4"></div>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-warning btn-lg">Réserver</button>
            </div>
        </form>
    </div>

    <script>
        // Gestion dynamique des champs pour les passagers
        document.getElementById('nombre_passagers').addEventListener('input', function () {
            const container = document.getElementById('passengers-container');
            container.innerHTML = ''; // Réinitialise les champs existants

            const nombrePassagers = parseInt(this.value);
            if (isNaN(nombrePassagers) || nombrePassagers < 1) return;

            // Génère les champs pour chaque passager
            for (let i = 1; i <= nombrePassagers; i++) {
                const passagerDiv = document.createElement('div');
                passagerDiv.classList.add('border', 'p-3', 'mb-4', 'bg-light', 'rounded');

                passagerDiv.innerHTML = `
                    <h6 class="text-primary">Passager ${i}</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Nom :</label>
                            <input type="text" class="form-control" name="passagers[${i}][nom]" placeholder="Nom du passager ${i}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Prénom :</label>
                            <input type="text" class="form-control" name="passagers[${i}][prenom]" placeholder="Prénom du passager ${i}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Téléphone :</label>
                            <input type="text" class="form-control" name="passagers[${i}][telephone]" placeholder="Téléphone du passager ${i}" required>
                        </div>
                    </div>
                `;

                container.appendChild(passagerDiv);
            }
        });

        // Validation côté client (Bootstrap)
        (function () {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
