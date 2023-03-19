<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer("pay_id")->nullable();  
            $table->string('raison_sociale')->nullable();
            $table->string('email')->nullable();
            $table->string('contact1')->nullable();
            $table->string('contact2')->nullable();
            $table->boolean('est_active')->default(true);
            $table->boolean('est_archive')->default(false);
            
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
        Schema::dropIfExists('clients');
    }
}
