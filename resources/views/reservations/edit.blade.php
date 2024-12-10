@extends('layouts.app')
@section('content')
    <div class="card mt-3 hadow-lg p-3 mb-5 rounded" style="margin-left:-8%;">
      <div class="card-header bg-warning">
      <h1 class="text-center text-white">Ajouter une reservation</h1>
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
      
    <form method='Post' action="{{route('reservations.update', $reservation->id)}}">
    @csrf
    @method('PUT')

   <div class="mb-3">
    <label for="date" class="form-label">Date</label>
    <input type="date" class="form-control" value="{{$reservation->date}}" id="date"name="date">
  </div>

    <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Statut</label>
    <input type="text" class="form-control" value="{{$reservation->statut}}" id="statut"name="statut">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Classe</label>
    <input type="text" class="form-control" value="{{$reservation->classe}}" id="classe"name="classe">
  </div>
  <button type="submit" class="btn btn-warning">Modifierr</button>
</form>
    </div>
</div>
@endsection