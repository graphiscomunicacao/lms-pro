<?php
namespace App\Http\Controllers\Api;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\LearningPathGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathGroupCollection;

class TeamLearningPathGroupsController extends Controller
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

        $learningPathGroups = $team
            ->learningPathGroups()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathGroupCollection($learningPathGroups);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Team $team,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('update', $team);

        $team
            ->learningPathGroups()
            ->syncWithoutDetaching([$learningPathGroup->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Team $team,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('update', $team);

        $team->learningPathGroups()->detach($learningPathGroup);

        return response()->noContent();
    }
}
