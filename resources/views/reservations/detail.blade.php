@extends('layouts.app')
@section('content')
<div class="container mt-5">
<div class="card">
    <div class="card-header bg-warning ">
       <h3 class="text-center text-white">Detail Reservation N°:{{$reservation->id}}</h3> 
    </div>
    <div class="card-body">
        <p>date :{{$reservation->date}}</p>
        <p>statut :{{$reservation->statut}}</p>
        <p>classe :{{$reservation->classe}}</p>
        
        <p>date d'ajout :{{$reservation->created_at}}</p>
        <p>date de modification :{{$reservation->updated_at}}</p>
        </div>
    </div>
</div>
<p>

</p>
@endsection