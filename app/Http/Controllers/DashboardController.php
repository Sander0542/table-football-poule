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

                $gameUsers = $games->pluck('users')->flatten()->groupBy('id');

                $team = $request->user()->currentTeam;

                return [
                    'players' => $team->getTeamMembers()
                        ->map(function ($player) use ($gameUsers) {
                            return [
                                'player' => $player,
                                'games' => $gameUsers[$player->id] ?? collect(),
                            ];
                        })
                        ->map(function ($data) {
                            return [
                                'name' => $data['player']->name,
                                'games' => $data['games']->count(),
                                'wins' => $data['games']->filter(function ($game) {
                                    return $game->pivot->winner;
                                })->count(),
                                'losses' => $data['games']->filter(function ($game) {
                                    return !$game->pivot->winner;
                                })->count(),
                            ];
                        })
                        ->sortBy('name')
                        ->sortByDesc('wins')
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
