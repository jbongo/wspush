<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieinternesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorieinternes', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();         
            $table->integer('categoriearticle_id')->nullable();
            $table->integer("siteinterne_id")->nullable();         
            $table->integer("wp_id")->nullable();         
            $table->string("url")->nullable();           
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
        Schema::dropIfExists('categorieinternes');
    }
}
