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
    <div class="form-group">
                    <label for="ville_depart_id">Ville</label>
                    <select name="ville_id" id="ville_id"  class="form-control" required>
                        <option value="" disabled selected>Choisissez une ville</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" {{ $hotel->ville_id == $ville->id ? 'selected' : '' }}>{{ $ville->nom }} ({{ $ville->pays }})</option>
                        @endforeach
                    </select>
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