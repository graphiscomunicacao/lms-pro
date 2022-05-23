<?php
namespace App\Http\Controllers\Api;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamCollection;

class LearningPathTeamsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LearningPath $learningPath)
    {
        $this->authorize('view', $learningPath);

        $search = $request->get('search', '');

        $teams = $learningPath
            ->teams()
            ->search($search)
            ->latest()
            ->paginate();

        return new TeamCollection($teams);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningPath $learningPath,
        Team $team
    ) {
        $this->authorize('update', $learningPath);

        $learningPath->teams()->syncWithoutDetaching([$team->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningPath $learningPath,
        Team $team
    ) {
        $this->authorize('update', $learningPath);

        $learningPath->teams()->detach($team);

        return response()->noContent();
    }
}
