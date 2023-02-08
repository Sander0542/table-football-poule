<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Inertia\Inertia;

class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Players/Index', [
            'players' => Auth::user()->currentTeam->getTeamMembers()->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'wins' => $user->userGames()->where('winner', true)->count(),
                ];
            }),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function show(User $user)
    {
        $user->load(['games']);

        return Inertia::render('Players/Show', [
            'player' => $user,
        ]);
    }
}
