<?php
namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamCollection;

class MenuTeamsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Menu $menu)
    {
        $this->authorize('view', $menu);

        $search = $request->get('search', '');

        $teams = $menu
            ->teams()
            ->search($search)
            ->latest()
            ->paginate();

        return new TeamCollection($teams);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Menu $menu, Team $team)
    {
        $this->authorize('update', $menu);

        $menu->teams()->syncWithoutDetaching([$team->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Menu $menu, Team $team)
    {
        $this->authorize('update', $menu);

        $menu->teams()->detach($team);

        return response()->noContent();
    }
}
