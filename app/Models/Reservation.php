<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_reservation',
        'date',
        'statut',
        'user_id',
        'prix',
        'nombre_places',
        'compagnie',
        'origine',
        'destination',
        'heure_depart',
        'heure_arrivee',
        'nom_hotel',
        'ville_hotel',
        'date_arrivee',
        'date_depart',
        'passagers',
    ];

    // Décoder automatiquement les passagers JSON
    protected $casts = [
        'passagers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
