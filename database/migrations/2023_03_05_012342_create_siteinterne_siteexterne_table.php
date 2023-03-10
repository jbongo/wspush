<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Siteinterne;
use App\Models\Siteexterne;


class CreateSiteinterneSiteexterneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siteinterne_siteexterne', function (Blueprint $table) {
            $table->id();
            $table->primary(['siteinterne_id','siteexterne_id']);
            $table->foreignIdFor(Siteinterne::class);
            $table->foreignIdFor(Siteexterne::class);
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
        Schema::dropIfExists('siteinterne_siteexterne');
    }
}
