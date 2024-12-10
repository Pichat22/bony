@extends('layouts.app')
@section('content')
<div class="card mt-3 hadow-lg p-3 mb-5 rounded" style="margin-left:-8%;">
    <div class="card-header bg-warning">
      <h1 text-center text-white>Ajouter un hotel</h1>
      </div>
      <div class="card-body">
      @if($errors->any())
      <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
      </ul>
      </div>
      @endif
      
    <form method='Post' action="{{route('hotels.update', $hotel->id)}}">
    @csrf
    @method('PUT')
    <div class="mb-3">
    <label for="ville" class="form-label">Ville</label>
    <input type="text" class="form-control" value="{{$hotel->ville}}" id="ville"name="ville">
  </div>
    <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Nom</label>
    <input type="text" class="form-control" value="{{$hotel->nom}}" id="exampleInputPassword1"name="nom">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Adresse</label>
    <input type="text" class="form-control" value="{{$hotel->adresse}}" id="exampleInputPassword1"name="adresse">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Etoil</label>
    <input type="text" class="form-control" value="{{$hotel->etoil}}" id="exampleInputPassword1"name="etoil">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Prix</label>
    <input type="number" class="form-control" value="{{$hotel->prix}}" id="exampleInputPassword1"name="prix">
  </div>
  <button type="submit" class="btn btn-warning">Modifier</button>
</form>
    </div>
</div>
@endsection