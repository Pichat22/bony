@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4 w-50 mx-auto">
        <div class="card-header bg-warning ">
            <h3 class="text-center">{{ __('Inscription Utilisateur') }}</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="/user">
                @csrf

                <!-- Nom -->
                <div class="mb-3">
                    <label for="nom" class="form-label">{{ __('Nom') }}</label>
                    <input id="name" type="text" class="form-control" name="nom" :value="old('name')" required autofocus autocomplete="name">
                    @error('nom')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control" name="email" :value="old('email')" required autocomplete="username">
                    @error('email')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                    @error('password')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmer le mot de passe -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sélection du rôle -->
                <div class="mb-3">
                    <label for="role" class="form-label">{{ __('S’inscrire en tant que') }}</label>
                    <div>
                        <label>
                            <input type="radio" name="role" value="client"> {{ __('Client') }}
                        </label>
                        <label class="ms-4">
                            <input type="radio" name="role" value="admin"> {{ __('Administrateur') }}
                        </label>
                    </div>
                    @error('role')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton Envoyer -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning">
                        {{ __('Envoyer') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
