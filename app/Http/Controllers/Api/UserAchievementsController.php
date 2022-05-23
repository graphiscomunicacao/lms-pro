<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AchievementCollection;

class UserAchievementsController extends Controller
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

        $achievements = $user
            ->achievements()
            ->search($search)
            ->latest()
            ->paginate();

        return new AchievementCollection($achievements);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        User $user,
        Achievement $achievement
    ) {
        $this->authorize('update', $user);

        $user->achievements()->syncWithoutDetaching([$achievement->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        User $user,
        Achievement $achievement
    ) {
        $this->authorize('update', $user);

        $user->achievements()->detach($achievement);

        return response()->noContent();
    }
}
