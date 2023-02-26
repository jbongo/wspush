<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siteexterne extends Model
{
    use HasFactory;
    protected $guarded = [];


   /**
     * retournes les catégories du site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categorieexternes()
    {
        return $this->hasMany(Categorieexterne::class);
    }
    
}