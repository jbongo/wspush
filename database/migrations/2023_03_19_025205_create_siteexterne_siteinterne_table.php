<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Siteinterne;
use App\Models\Siteexterne;


class CreateSiteexterneSiteinterneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siteexterne_siteinterne', function (Blueprint $table) {
            $table->id();
            $table->primary(['siteexterne_id','siteinterne_id']);
            $table->foreignIdFor(Siteexterne::class);
            $table->foreignIdFor(Siteinterne::class);
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
        Schema::dropIfExists('siteexterne_siteinterne');
    }
}
