@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white text-center">
            <h2 class="mb-0">Rechercher un Trajet</h2>
        </div>
        <div class="card-body">
            <!-- Affichage des messages d'erreur -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Formulaire de recherche -->
            <form method="POST" action="{{ route('reservations.search.post') }}">
                @csrf
                <!-- Recherche Ville de départ -->
                <div class="form-group mb-4">
                    <label for="ville_depart" class="fw-bold">Ville de départ</label>
                    <div class="input-group">
                        <input type="text" id="ville_depart" class="form-control" placeholder="Recherchez une ville" autocomplete="off">
                        <ul id="ville_depart_suggestions" class="list-group position-absolute w-100" style="z-index: 1000;"></ul>
                    </div>
                    <!-- Champ caché pour le code IATA de la ville de départ -->
                    <input type="hidden" name="ville_depart" id="ville_depart_code">
                </div>

                <!-- Recherche Ville d'arrivée -->
                <div class="form-group mb-4">
                    <label for="ville_arrivee" class="fw-bold">Ville d'arrivée</label>
                    <div class="input-group">
                        <input type="text" id="ville_arrivee" class="form-control" placeholder="Recherchez une ville" autocomplete="off">
                        <ul id="ville_arrivee_suggestions" class="list-group position-absolute w-100" style="z-index: 1000;"></ul>
                    </div>
                    <!-- Champ caché pour le code IATA de la ville d'arrivée -->
                    <input type="hidden" name="ville_arrivee" id="ville_arrivee_code">
                </div>

                <!-- Date de départ -->
                <div class="form-group mb-4">
                    <label for="date_depart" class="fw-bold">Date de départ</label>
                    <input type="date" name="date_depart" id="date_depart" class="form-control" required>
                </div>

                <!-- Bouton de soumission -->
                <div class="text-center">
                    <button type="submit" class="btn btn-warning btn-lg">Rechercher</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script pour les suggestions -->
<script>
    let debounceTimeout;

    function fetchSuggestions(query, field) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            if (query.length < 2) return; // Minimum 2 caractères
            fetch(`/api/search-cities?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById(`${field}_suggestions`);
                    list.innerHTML = ''; // Efface les anciennes suggestions
                    data.data.forEach(location => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item', 'list-group-item-action');
                        li.textContent = location.name; // Affiche le nom de la ville
                        li.addEventListener('click', () => {
                            document.getElementById(field).value = location.name; // Remplit le champ avec le nom
                            document.getElementById(`${field}_code`).value = location.iataCode; // Remplit le champ caché avec le code
                            list.innerHTML = ''; // Efface les suggestions après sélection
                        });
                        list.appendChild(li);
                    });
                })
                .catch(console.error);
        }, 300); // Ajoute un délai de 300ms
    }

    document.getElementById('ville_depart').addEventListener('input', function () {
        fetchSuggestions(this.value, 'ville_depart');
    });

    document.getElementById('ville_arrivee').addEventListener('input', function () {
        fetchSuggestions(this.value, 'ville_arrivee');
    });
</script>
@endsection
