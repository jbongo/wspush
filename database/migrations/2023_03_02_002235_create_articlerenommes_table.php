<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlerenommesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articlerenommes', function (Blueprint $table) {
            $table->id();
            $table->integer('article_id')->nullable();
            $table->integer('categorieexterne_id')->nullable();
            $table->integer('siteexterne_id')->nullable();
            $table->integer("langue_id")->nullable();  
            $table->integer('client_id')->nullable();
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('url')->nullable();
            $table->boolean('est_brouillon')->default(false);
            $table->boolean('est_archive')->default(false);
            $table->boolean('est_publie')->default(false);
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
        Schema::dropIfExists('articlerenommes');
    }
}
