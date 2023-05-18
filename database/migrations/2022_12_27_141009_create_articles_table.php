<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->integer('categorieexterne_id')->nullable();
            $table->integer('siteexterne_id')->nullable();
            $table->integer('categoriearticle_id')->nullable();
            $table->integer("user_id")->nullable();  
            $table->integer("langue_id")->nullable();  
            $table->integer('client_id')->nullable();
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->longText('image')->nullable();
            $table->text('url')->nullable();
            $table->boolean('est_brouillon')->default(false);
            $table->boolean('est_archive')->default(false);
            $table->boolean('est_publie')->default(false);
            $table->boolean('est_scrappe')->default(true);
            $table->boolean('est_publie_tous_site')->default(true);
            $table->date('date_publication')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
