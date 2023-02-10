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
            $table->string('nom')->nullable();
            $table->text('url')->nullable();
            $table->string('pays')->nullable();
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
        Schema::dropIfExists('siteinternes');
    }
}
