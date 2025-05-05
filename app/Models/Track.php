<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tracks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['trackname', 'description'];

    /**
     * Get the strands associated with the track.
     *
     * @return HasMany
     */
    public function strands(): HasMany
    {
        return $this->hasMany(Strand::class, 'track_id', 'id');
    }
}
