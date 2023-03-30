<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoriearticle extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the categorieinterne for the Categoriearticle
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categorieinternes()
    {
        return $this->hasMany(Categorieinterne::class);
    }

        /**
     * Get all of the categorieinterne for the Categoriearticle
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categorieexternes()
    {
        return $this->hasMany(Categorieexterne::class);
    }
}
