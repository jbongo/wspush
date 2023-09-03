<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Categorieinterne;
use App\Models\Categorieexterne;


class CreateCategorieexterneCategorieinterneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorieexterne_categorieinterne', function (Blueprint $table) {
            $table->id();
            // $table->primary(['categorieexterne_id','categorieinterne_id']);
            $table->integer('categorieinterne_id');
            $table->integer('categorieexterne_id');
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
        Schema::dropIfExists('categorieexterne_categorieinterne');
    }
}
