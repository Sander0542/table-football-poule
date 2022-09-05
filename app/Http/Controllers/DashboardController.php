<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Dashboard/Index', [
            'stats' => function () use ($request) {
                $periodStart = $request->get('start');
                $periodEnd = $request->get('end');

                $games = $this->queryWithPeriod(Game::with('users'), $periodStart, $periodEnd)
                    ->orderByDesc('played_at')
                    ->get();

                return [
                    'players' => $games->pluck('users')
                        ->flatten()
                        ->groupBy('id')
                        ->map(function ($user) {
                            return [
                                'name' => $user->first()->name,
                                'games' => $user->count(),
                                'wins' => $user->filter(function ($user) {
                                    return $user->pivot->winner;
                                })->count(),
                                'loses' => $user->filter(function ($user) {
                                    return !$user->pivot->winner;
                                })->count(),
                            ];
                        })->sortByDesc('wins')
                        ->values(),
                    'teams' => $games->pipe(function ($games) {
                        return collect([
                            [
                                'name' => 'blue',
                                'score' => $games->filter(function ($game) {
                                    return $game->score_blue >= $game->score_red;
                                })->count()
                            ],
                            [
                                'name' => 'red',
                                'score' => $games->filter(function ($game) {
                                    return $game->score_blue <= $game->score_red;
                                })->count()
                            ],
                        ]);
                    })->sortDesc()->values(),
                ];
            },
        ]);
    }

    private function queryWithPeriod(Builder $query, $periodStart, $periodEnd)
    {
        if ($periodStart) {
            $query = $query->whereDate('played_at', '>=', $periodStart);
        }
        if ($periodEnd) {
            $query = $query->whereDate('played_at', '<=', $periodEnd);
        }

        return $query;
    }
}
