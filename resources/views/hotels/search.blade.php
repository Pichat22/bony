@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg">
        <!-- En-tête avec le titre -->
        <div class="card-header bg-warning text-white text-center">
            <h2>Rechercher un Hôtel</h2>
        </div>

        <!-- Corps du formulaire -->
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulaire -->
            <form method="POST" action="{{ route('hotels.search') }}" class="needs-validation" novalidate>
                @csrf

                <!-- Recherche Ville -->
                <div class="form-group mb-4 position-relative">
                    <label for="city_input" class="fw-bold">Ville</label>
                    <input type="text" class="form-control" id="city_input" placeholder="Tapez une ville..." autocomplete="off">
                    <input type="hidden" name="city_code" id="city_code">
                    <ul class="list-group position-absolute w-100" id="city_suggestions" style="z-index: 1000;"></ul>
                </div>

                <!-- Date d'Arrivée -->
                <div class="form-group mb-4">
                    <label for="check_in_date" class="fw-bold">Date d'Arrivée</label>
                    <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                    <div class="invalid-feedback">Veuillez sélectionner une date d'arrivée valide.</div>
                </div>

                <!-- Date de Départ -->
                <div class="form-group mb-4">
                    <label for="check_out_date" class="fw-bold">Date de Départ</label>
                    <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                    <div class="invalid-feedback">Veuillez sélectionner une date de départ valide.</div>
                </div>

                <!-- Bouton Rechercher -->
                <button type="submit" class="btn btn-warning btn-lg w-100">Rechercher</button>
            </form>
        </div>
    </div>
</div>

<!-- Script JavaScript pour la recherche de villes -->
<script>
    let debounceTimeout;

    document.getElementById('city_input').addEventListener('input', function () {
        const query = this.value.trim();
        const suggestionsContainer = document.getElementById('city_suggestions');
        suggestionsContainer.innerHTML = ''; // Vide les suggestions précédentes

        if (query.length < 2) return; // Minimum 2 caractères pour lancer la recherche

        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            fetch(`/api/cities?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }

                    // Affiche les suggestions
                    data.data.forEach(city => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item');
                        li.textContent = `${city.name} (${city.iataCode})`;
                        li.style.cursor = 'pointer';
                        li.addEventListener('click', () => {
                            document.getElementById('city_input').value = city.name;
                            document.getElementById('city_code').value = city.iataCode;
                            suggestionsContainer.innerHTML = ''; // Vide les suggestions
                        });
                        suggestionsContainer.appendChild(li);
                    });
                })
                .catch(err => console.error('Erreur API :', err));
        }, 300); // Délai pour éviter les requêtes trop fréquentes
    });

    // Validation Bootstrap
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
