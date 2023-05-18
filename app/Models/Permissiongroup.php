<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissiongroup extends Model
{
    use HasFactory;
    
    protected $guarded = [];


    /**
     * Retourne la liste des permissions d'un groupe permission
     */
    function permissions(){

        return $this->hasMany(Permission::class);

      }
}
