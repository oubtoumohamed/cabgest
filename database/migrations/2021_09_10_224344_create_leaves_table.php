<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();

            $table->date('from'); 
            $table->date('to'); 
            $table->integer('days')->nullable(); 

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
            
            $table->string('notes')->nullable(); 
            $table->string('state')->nullable(); 
            $table->string('comment')->nullable(); 
            
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
        Schema::dropIfExists('leaves');
    }
}
