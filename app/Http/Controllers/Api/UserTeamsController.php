<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamCollection;

class UserTeamsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $teams = $user
            ->teams()
            ->search($search)
            ->latest()
            ->paginate();

        return new TeamCollection($teams);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Team $team)
    {
        $this->authorize('update', $user);

        $user->teams()->syncWithoutDetaching([$team->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user, Team $team)
    {
        $this->authorize('update', $user);

        $user->teams()->detach($team);

        return response()->noContent();
    }
}
