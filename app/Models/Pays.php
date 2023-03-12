<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the siteinternes for the Pays
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siteinternes()
    {
        return $this->hasMany(Siteinterne::class);
    }

     /**
     * Get all of the siteexternes for the Pays
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siteexternes()
    {
        return $this->hasMany(Siteexterne::class);
    }
}
