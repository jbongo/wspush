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
    public function Siteexterne()
    {
        return $this->belongsToMany(Siteexterne::class);
    }

}
