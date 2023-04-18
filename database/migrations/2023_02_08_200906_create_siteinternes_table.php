<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteinternesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siteinternes', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer("pay_id")->nullable();
            $table->integer("langue_id")->nullable();  
            $table->string('nom')->nullable();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->text('url')->nullable();
            $table->boolean('est_archive')->default(false);
            $table->boolean('est_actif')->default(true);
            $table->boolean('est_diffuse_auto')->default(false);
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
        Schema::dropIfExists('siteinternes');
    }
}
