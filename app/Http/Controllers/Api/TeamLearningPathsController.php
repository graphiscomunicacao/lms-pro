<?php
namespace App\Http\Controllers\Api;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathCollection;

class TeamLearningPathsController extends Controller
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

        $learningPaths = $team
            ->learningPaths()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathCollection($learningPaths);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Team $team,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $team);

        $team->learningPaths()->syncWithoutDetaching([$learningPath->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Team $team,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $team);

        $team->learningPaths()->detach($learningPath);

        return response()->noContent();
    }
}
