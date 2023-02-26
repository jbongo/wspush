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
}
