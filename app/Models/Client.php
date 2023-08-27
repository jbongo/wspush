<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the pays that owns the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pay()
    {
        return $this->belongsTo(Pays::class);
    }

    /**
     * Get the langue that owns the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    /**
     * Get all of the users for the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Retourne le nombre d'utlisateurs du client
     *
     */
    public function nbUsers(): Int
    {
  
        return count($this->users);
    }

}
