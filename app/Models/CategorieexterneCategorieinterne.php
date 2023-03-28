<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieexterneCategorieinterne extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'categorieexterne_categorieinterne';

 
    /**
     * Retourne la liste des categories internes associé à la catégorie
     */
    function categorieinterne()
    {
        return $this->belongsTo(Categorieinterne::class,);

    }

    /**
     * Retourne la liste des categories externes associé à la catégorie
     */
    function categorieexterne()
    {
        return $this->belongsTo(Categorieexterne::class,);

    }
}
