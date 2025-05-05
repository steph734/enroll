<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Strand extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'strand';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['strandname', 'description', 'track_id'];

    /**
     * Get the track that the strand belongs to.
     *
     * @return BelongsTo
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'track_id', 'id');
    }
}
