<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleinternesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articleinternes', function (Blueprint $table) {
            $table->id();
            $table->integer("article_id")->nullable();         
            $table->integer("articlerenomme_id")->nullable();         
            $table->integer("siteinterne_id")->nullable();         
            $table->integer("categorieinterne_id")->nullable();         
            $table->integer("postwp_id")->nullable();         
            $table->boolean('est_archive')->default(false);
            $table->boolean('est_renomme')->default(false);
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
        Schema::dropIfExists('articleinternes');
    }
}
