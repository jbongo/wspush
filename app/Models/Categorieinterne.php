<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorieinterne extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * retournes les catégories du site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function siteinterne()
    {
        return $this->belongsTo(Siteinterne::class);
    }


    /**
     * Retourne la liste des categories externes associée à la catégorie
     */
    function categorieexternes()
    {
        return $this->belongsToMany(Categorieexterne::class);
    }

    /**
     * Retourne true si la catégorie est liè à une catégorie externe
     */
    function HaveCategorieexterne($categorieexterne_id)
    {
        
        $categorie = CategorieexterneCategorieinterne::where([['categorieexterne_id', $categorieexterne_id], ['categorieinterne_id', $this->id]])->first();

        return $categorie != null ? true : false;
        
    }

    /**
     * The articles that belong to the Categorieinterne
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class)
                ->withPivot('articlerenomme_id','siteinterne_id','postwp_id','est_renomme','est_publie_auto')
                ->withTimestamps();
    }

    
    /**
     * Retourne true si la catégorie est liè à une catégorie externe
     */
    function haveArticle($article_id)
    {
        
        $article = ArticleCategorieinterne::where([['article_id', $article_id], ['categorieinterne_id', $this->id]])->first();

        return $article != null ? true : false;
        
    }


    /**
     * Get the categoriearticle that owns the Categorieexterne
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriearticle()
    {
        return $this->belongsTo(Categoriearticle::class);
    }
}
