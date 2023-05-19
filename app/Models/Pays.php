<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

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
        return $this->hasMany(Siteinterne::class,'pay_id','id');
    }

    /**
     * Get all of the siteinternes for the Pays
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siteinternesClient()
    {
      
        return $this->hasMany(Siteinterne::class,'pay_id','id')->where('client_id', Auth::user()->client_id);
    }


     /**
     * Get all of the siteexternes for the Pays
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siteexternes()
    {
        return $this->hasMany(Siteexterne::class,'pay_id','id');
    }
}
