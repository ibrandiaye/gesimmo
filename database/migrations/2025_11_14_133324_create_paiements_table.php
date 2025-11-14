<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
             $table->foreignId('contrat_id')->constrained()->onDelete('cascade');
            $table->integer('mois');
            $table->integer('annee');
            $table->decimal('montant', 10, 2);
            $table->date('date_paiement');
            $table->enum('statut', ['paye', 'en_retard', 'partiel'])->default('paye');
            $table->string('mode_paiement');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('paiements');
    }
}
