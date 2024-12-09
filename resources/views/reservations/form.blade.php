@extends('layouts.app')

@section('content')
<div class="card mt-3 hadow-lg p-3 mb-5 rounded" style="margin-left:-8%;">
    <div class="card-header bg-warning">
    <h1 text-center text-white>Rechercher un trajet</h1>
    </div>
    <div class="card-body">
    <form method="POST" action="{{ route('reservations.search') }}">
        @csrf

        <!-- Date de réservation -->
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <!-- Ville de départ -->
        <div class="form-group mt-3">
            <label for="ville_depart_id">Ville de départ</label>
            <select name="ville_depart_id" id="ville_depart_id" class="form-control" required>
                <option value="" disabled selected>Choisissez une ville</option>
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}">{{ $ville->nom }} ({{ $ville->pays }})</option>
                @endforeach
            </select>
        </div>

        <!-- Ville d'arrivée -->
        <div class="form-group mt-3">
            <label for="ville_arrivee_id">Ville d'arrivée</label>
            <select name="ville_arrivee_id" id="ville_arrivee_id" class="form-control" required>
                <option value="" disabled selected>Choisissez une ville</option>
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}">{{ $ville->nom }} ({{ $ville->pays }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-warning mt-3">Reserver</button>
    </form>
    </div>
    </div>
@endsection
