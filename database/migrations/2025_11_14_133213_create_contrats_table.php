<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
             $table->foreignId('locataire_id')->constrained()->onDelete('cascade');
            $table->foreignId('appartement_id')->constrained()->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->decimal('loyer_mensuel', 10, 2);
            $table->decimal('depot_garantie', 10, 2);
            $table->enum('statut', ['actif', 'resilie', 'expire'])->default('actif');
            $table->text('conditions_speciales')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrats');
    }
}
