@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white text-center">
            <h2 class="mb-0">Liste des Utilisateurs</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-warning opacity-75">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <!-- Colonne des informations -->
                                <td>{{ $user->nom }}</td>
                                <td>{{ $user->prenom }}</td>
                                <td>{{ $user->email }}</td>
                                
                                <!-- Colonne du rôle -->
                                <td>
                                    <span class="badge {{ $user->role === 'admin' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                
                                <!-- Colonne des actions -->
                                <td>
                                    <a href="{{ route('users.edit.role', $user->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="bi bi-pencil-square"></i> Modifier le Rôle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
