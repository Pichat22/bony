<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Type de réservation (billet ou hôtel)
            $table->string('type_reservation'); // 'billet' ou 'hotel'

            // Champs communs
            $table->date('date'); // Date de la réservation
            $table->string('statut')->default('en attente'); // Statut (en attente, confirmée, annulée)
            $table->unsignedBigInteger('user_id')->nullable(); // Utilisateur ayant effectué la réservation
            $table->decimal('prix', 10, 2)->nullable(); // Prix total
            $table->unsignedInteger('nombre_places')->nullable(); // Nombre de places (utile pour billets)

            // Champs spécifiques au billet d'avion
            $table->string('compagnie')->nullable(); // Compagnie aérienne
            $table->string('origine')->nullable(); // Origine (ville ou code IATA)
            $table->string('destination')->nullable(); // Destination (ville ou code IATA)
            $table->dateTime('heure_depart')->nullable(); // Heure de départ
            $table->dateTime('heure_arrivee')->nullable(); // Heure d'arrivée

            // Champs spécifiques à l'hôtel
            $table->string('nom_hotel')->nullable(); // Nom de l'hôtel
            $table->string('ville_hotel')->nullable(); // Ville de l'hôtel
            $table->dateTime('date_arrivee')->nullable(); // Date d'arrivée (check-in)
            $table->dateTime('date_depart')->nullable(); // Date de départ (check-out)

            // Informations sur les passagers ou clients
            $table->json('passagers')->nullable(); // Liste des passagers ou clients en JSON

            $table->timestamps();

            // Clé étrangère
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
