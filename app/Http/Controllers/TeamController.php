<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;

class TeamController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Team::class);

        $search = $request->get('search', '');

        $teams = Team::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.teams.index', compact('teams', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Team::class);

        return view('app.teams.create');
    }

    /**
     * @param \App\Http\Requests\TeamStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamStoreRequest $request)
    {
        $this->authorize('create', Team::class);

        $validated = $request->validated();

        $team = Team::create($validated);

        return redirect()
            ->route('teams.edit', $team)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Team $team)
    {
        $this->authorize('view', $team);

        return view('app.teams.show', compact('team'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        return view('app.teams.edit', compact('team'));
    }

    /**
     * @param \App\Http\Requests\TeamUpdateRequest $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function update(TeamUpdateRequest $request, Team $team)
    {
        $this->authorize('update', $team);

        $validated = $request->validated();

        $team->update($validated);

        return redirect()
            ->route('teams.edit', $team)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Team $team)
    {
        $this->authorize('delete', $team);

        $team->delete();

        return redirect()
            ->route('teams.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
