<?php
namespace App\Http\Controllers\Api;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\LearningPathGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamCollection;

class LearningPathGroupTeamsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('view', $learningPathGroup);

        $search = $request->get('search', '');

        $teams = $learningPathGroup
            ->teams()
            ->search($search)
            ->latest()
            ->paginate();

        return new TeamCollection($teams);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningPathGroup $learningPathGroup,
        Team $team
    ) {
        $this->authorize('update', $learningPathGroup);

        $learningPathGroup->teams()->syncWithoutDetaching([$team->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningPathGroup $learningPathGroup,
        Team $team
    ) {
        $this->authorize('update', $learningPathGroup);

        $learningPathGroup->teams()->detach($team);

        return response()->noContent();
    }
}
