<?php
namespace App\Http\Controllers\Api;

use App\Models\Team;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class TeamMenusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Team $team)
    {
        $this->authorize('view', $team);

        $search = $request->get('search', '');

        $menus = $team
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Team $team, Menu $menu)
    {
        $this->authorize('update', $team);

        $team->menus()->syncWithoutDetaching([$menu->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Team $team, Menu $menu)
    {
        $this->authorize('update', $team);

        $team->menus()->detach($menu);

        return response()->noContent();
    }
}
