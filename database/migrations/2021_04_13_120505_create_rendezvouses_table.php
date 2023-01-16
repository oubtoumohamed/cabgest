<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendezvousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendezvouses', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->integer('duree')->nullable();
            $table->string('etat')->nullable();
            $table->string('commentaire')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('motif_id')->nullable()->constrained()->onDelete('set null');

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
        Schema::dropIfExists('rendezvouses');
    }
}
