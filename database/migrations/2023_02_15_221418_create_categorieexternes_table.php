<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieexternesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorieexternes', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();         
            $table->string("url")->nullable();         
            $table->integer('siteexterne_id')->nullable();
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
        Schema::dropIfExists('categorieexternes');
    }
}
