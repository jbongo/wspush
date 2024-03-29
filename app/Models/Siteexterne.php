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

    /**
     * The Siteinterne that belong to the Siteexterne
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Siteinternes()
    {
        return $this->belongsToMany(Siteinterne::class);
    }

    /**
     * Get the pays that owns the Siteexterne
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pay()
    {
        return $this->belongsTo(Pays::class);
    }
    
}
