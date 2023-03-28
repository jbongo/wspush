<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Categorieinterne;
use App\Models\Article;

class CreateArticleCategorieinterneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_categorieinterne', function (Blueprint $table) {
            $table->id();
            $table->primary(['categorieinterne_id','article_id'])->nullable();
            $table->foreignIdFor(Categorieinterne::class);
            $table->foreignIdFor(Article::class);
            $table->integer("articlerenomme_id")->nullable();         
            $table->integer("siteinterne_id")->nullable();         
            $table->integer("titre_article")->nullable();         
            $table->integer("postwp_id")->nullable();         
            $table->boolean('est_archive')->default(false);
            $table->boolean('est_renomme')->default(false);
            $table->boolean('est_publie_auto')->default(false);
            $table->boolean('est_alimente')->default(false);
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
        Schema::dropIfExists('article_categorieinterne');
    }
}
