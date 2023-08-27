<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articlevariant extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the article that owns the Articlevariant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
