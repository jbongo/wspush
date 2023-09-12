<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siteinterne extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The Siteexterne that belong to the Siteexterne
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Siteexternes()
    {
        return $this->belongsToMany(Siteexterne::class);
    }

     /**
     * The Siteexterne wp that belong to the Siteexterne
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function SiteexternesWp()
    {
        return $this->belongsToMany(Siteexterne::class)->where("est_wordpress", true);
    }


    /**
     * Get the pays that owns the Siteinterne
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pay()
    {
        // dd($this);
        return $this->belongsTo(Pays::class);
    }
    /**
     * Get the client that owns the Siteinterne
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        // dd($this);
        return $this->belongsTo(Client::class);
    }


    /**
     * Retourne true si l'article existe a déjà sur le site
     */
    function haveArticle($titre_article)
    {
        
        $article = ArticleCategorieinterne::where([['titre_article', $titre_article], ['siteinterne_id', $this->id]])->first();

        return $article != null ? true : false;
        
    }

}
