<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('cin')->nullable();
            //$table->string('passeport')->nullable();
            $table->string('email')->nullable();
            $table->string('ville')->nullable();
            $table->string('adresse')->nullable();
            $table->string('tele')->nullable();
            $table->string('fax')->nullable();
            $table->string('commentaire')->nullable();
            $table->string('sexe')->nullable();
            $table->string('civilite')->nullable();
            $table->string('epoux')->nullable();
            
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
