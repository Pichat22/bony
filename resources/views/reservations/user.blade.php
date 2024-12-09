@extends('layouts.app')
@section('content')
@foreach($reservations as reservation )
<h1>{{reservation->first()->user->nom}}</h1>

@endforeach
@endsection