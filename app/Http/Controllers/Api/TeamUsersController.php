<?php
namespace App\Http\Controllers\Api;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class TeamUsersController extends Controller
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

        $users = $team
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Team $team, User $user)
    {
        $this->authorize('update', $team);

        $team->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Team $team, User $user)
    {
        $this->authorize('update', $team);

        $team->users()->detach($user);

        return response()->noContent();
    }
}
