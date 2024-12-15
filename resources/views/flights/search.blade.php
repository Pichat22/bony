@extends('layouts.app')

@section('content')
    <h1>Rechercher un trajet</h1>

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
    <form method="POST" action="{{ route('reservations.search') }}">
    @csrf
        <!-- Recherche Ville de départ -->
        <div class="form-group">
            <label for="ville_depart">Ville de départ</label>
            <input type="text" id="ville_depart" class="form-control" placeholder="Recherchez une ville" autocomplete="off">
            <ul id="ville_depart_suggestions" class="list-group"></ul>
        </div>
    
        <!-- Champ caché pour le code IATA de la ville de départ -->
        <input type="hidden" name="ville_depart" id="ville_depart_code">
    
        <!-- Recherche Ville d'arrivée -->
        <div class="form-group mt-3">
            <label for="ville_arrivee">Ville d'arrivée</label>
            <input type="text" id="ville_arrivee" class="form-control" placeholder="Recherchez une ville" autocomplete="off">
            <ul id="ville_arrivee_suggestions" class="list-group"></ul>
        </div>
    
        <!-- Champ caché pour le code IATA de la ville d'arrivée -->
        <input type="hidden" name="ville_arrivee" id="ville_arrivee_code">
    
        <!-- Date de départ -->
        <div class="form-group mt-3">
            <label for="date_depart">Date de départ</label>
            <input type="date" name="date_depart" id="date_depart" class="form-control" required>
        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Rechercher</button>
    </form>

    <script>
      
      let debounceTimeout; // Déclarez la variable en dehors de la fonction

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
                    li.classList.add('list-group-item');
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
