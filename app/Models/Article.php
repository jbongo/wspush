<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

     /**
     * retournes la catégorie de l'article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categorieexterne()
    {
        return $this->belongsTo(Categorieexterne::class);
    }


     /**
     * retournes le site de l'article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function siteexterne()
    {
        return $this->belongsTo(Siteexterne::class);
    }
}
