<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDossiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();

            $table->string('numero')->nullable();
            
            $table->bigInteger('patient_id')->unsigned()->nullable();
            $table->foreign('patient_id')
                    ->references('id')
                    ->on('patients')
                    ->onDelete('set null');

            $table->dateTime('datetime')->nullable();
            $table->double('poids')->nullable();
            $table->double('taille')->nullable();
            $table->double('tension')->nullable();
            $table->string('comment')->nullable();

            $table->bigInteger('caisse_id')->unsigned()->nullable();
            $table->foreign('caisse_id')
                    ->references('id')
                    ->on('caisses')
                    ->onDelete('set null');

            $table->bigInteger('motif_id')->unsigned()->nullable();
            $table->foreign('motif_id')
                    ->references('id')
                    ->on('motifs')
                    ->onDelete('set null');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');
            
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
        Schema::dropIfExists('dossiers');
    }
}
