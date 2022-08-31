<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'score_blue',
        'score_red',
        'played_at',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(GameUser::class)->withPivot([
            'winner',
            'team',
            'position',
        ]);
    }
}
