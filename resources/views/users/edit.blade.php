@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center text-warning mb-4">Modifier le Rôle de l'Utilisateur</h1>

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('users.update.role', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group mb-3">
                    <label for="role" class="fw-bold">Rôle</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Client</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning w-100">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>
@endsection
