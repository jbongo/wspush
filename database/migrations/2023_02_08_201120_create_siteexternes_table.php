<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteexternesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siteexternes', function (Blueprint $table) {
            $table->id();
            $table->integer("pay_id")->nullable();  
            $table->string('nom')->nullable();
            $table->text('url')->nullable(); 
            $table->string('selecteur_lien')->nullable();
            $table->string('selecteur_titre')->nullable();
            $table->string('selecteur_contenu')->nullable();
            $table->string('selecteur_image')->nullable();
            $table->boolean('image_affiche_css')->default(false);
            $table->boolean('est_archive')->default(false);
            $table->boolean('est_actif')->default(true);
            $table->boolean('est_wordpress')->default(false);
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
        Schema::dropIfExists('siteexternes');
    }
}
