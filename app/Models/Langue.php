<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langue extends Model
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
}
