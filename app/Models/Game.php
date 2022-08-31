<?php

namespace App\Models;

use App\Models\Scopes\CurrentTeamScope;
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

    protected $casts = [
        'played_at' => 'datetime',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(GameUser::class)->withPivot([
            'winner',
            'team',
            'position',
        ]);
    }

    protected static function booted()
    {
        static::addGlobalScope(new CurrentTeamScope());
    }
}
