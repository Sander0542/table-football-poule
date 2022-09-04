<?php

namespace App\Http\Controllers;

use App\Http\Requests\Games\GameRequest;
use App\Models\Game;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Games/Index', [
            'games' => Game::with('users')->orderByDesc('played_at')->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Games/Create', [
            'users' => Auth::user()->currentTeam->getTeamMembers(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GameRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GameRequest $request)
    {
        $data = $request->validated();

        $users = $this->playersToUsers($data['players'], $data['score_blue'], $data['score_red']);

        $game = Game::create([
            'team_id' => Auth::user()->currentTeam->id,
            'played_at' => $data['played_at'],
            'score_blue' => $data['score_blue'],
            'score_red' => $data['score_red'],
        ]);

        $game->users()->sync($users);

        return redirect()->route('games.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Game  $game
     * @return Response
     */
    public function show(Game $game)
    {
        $game->load(['users']);

        return Inertia::render('Games/Show', [
            'game' => $game,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Game  $game
     * @return Response
     */
    public function edit(Game $game)
    {
        return Inertia::render('Games/Edit', [
            'users' => Auth::user()->currentTeam->getTeamMembers(),
            'game' => $game,
            'players' => $game->users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'team' => $user->pivot->team,
                    'position' => $user->pivot->position,
                ];
            }),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GameRequest  $request
     * @param  Game  $game
     * @return RedirectResponse
     */
    public function update(GameRequest $request, Game $game)
    {
        $data = $request->validated();

        $users = $this->playersToUsers($data['players'], $data['score_blue'], $data['score_red']);

        $game->update([
            'played_at' => $data['played_at'],
            'score_blue' => $data['score_blue'],
            'score_red' => $data['score_red'],
        ]);
        $game->users()->sync($users);

        return redirect()->route('games.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Game  $game
     * @return RedirectResponse
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('games.index');
    }

    /**
     * Convert the players array to a users array for syncing with the game.
     *
     * @param $players array The players to convert.
     * @param $scoreBlue int The score of the blue team.
     * @param $scoreRed int The score of the red team.
     * @return Collection
     */
    private function playersToUsers(array $players, int $scoreBlue, int $scoreRed)
    {
        return collect($players)->mapWithKeys(function ($player) use ($scoreBlue, $scoreRed) {
            return [
                $player['id'] => [
                    'team' => $player['team'],
                    'position' => $player['position'],
                    'winner' => $player['team'] === 'blue' ? $scoreBlue >= $scoreRed : $scoreRed >= $scoreBlue,
                ]
            ];
        });
    }
}
