@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center text-primary">Formulaire de Réservation</h1>

        <!-- Carte principale -->
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center text-uppercase">Informations du Vol</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold">Compagnie :</label>
                        <input type="text" class="form-control" name="compagnie" 
                               value="{{ $flight['airlineName'] ?? ($flight['validatingAirlineCodes'][0] ?? 'Non spécifiée') }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Prix :</label>
                        <input type="text" class="form-control" name="prix" 
                               value="{{ $flight['price']['total'] ?? '0' }} {{ $flight['price']['currency'] ?? 'EUR' }}" readonly>
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
                               value="{{ \Carbon\Carbon::parse($flight['itineraries'][0]['segments'][0]['departure']['at'] ?? now())->format('d/m/Y H:i') }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Heure d'Arrivée :</label>
                        <input type="text" class="form-control" name="heure_arrivee" 
                               value="{{ \Carbon\Carbon::parse($flight['itineraries'][0]['segments'][0]['arrival']['at'] ?? now())->format('d/m/Y H:i') }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire dynamique pour les passagers -->
        <form method="POST" action="{{ route('reservations.store') }}" class="mt-5">
            @csrf
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title text-center text-uppercase">Informations des Passagers</h5>
                    <div class="form-group mb-4">
                        <label class="fw-bold">Nombre de Passagers :</label>
                        <input type="number" class="form-control" id="nombre_passagers" name="nombre_passagers" placeholder="Entrez le nombre de passagers" min="1" required>
                    </div>
                    <div id="passengers-container" class="mt-4"></div>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary btn-lg">Réserver</button>
            </div>
        </form>
    </div>

    <script>
        // Gestion dynamique des passagers
        document.getElementById('nombre_passagers').addEventListener('input', function () {
            const container = document.getElementById('passengers-container');
            container.innerHTML = ''; // Réinitialise les champs

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
    </script>
@endsection
