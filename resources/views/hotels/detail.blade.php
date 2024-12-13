@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-warning">
            <h3 class="text-center text-white">Détail Hôtel N° {{$hotel->id}}</h3>
        </div>
        <div class="card-body">
            <p><strong>Nom :</strong> {{$hotel->nom}}</p>
            <p><strong>Adresse :</strong> {{$hotel->adresse}}</p>
            <p><strong>Étoiles :</strong> {{$hotel->etoil}}</p>
            <p><strong>Prix :</strong> {{$hotel->prix}}</p>
        </div>
    </div>
</div>
@endsection
