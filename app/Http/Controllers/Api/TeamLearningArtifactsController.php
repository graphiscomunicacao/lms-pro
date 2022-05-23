<?php
namespace App\Http\Controllers\Api;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\LearningArtifact;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningArtifactCollection;

class TeamLearningArtifactsController extends Controller
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

        $learningArtifacts = $team
            ->learningArtifacts()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningArtifactCollection($learningArtifacts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Team $team,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('update', $team);

        $team
            ->learningArtifacts()
            ->syncWithoutDetaching([$learningArtifact->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Team $team,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('update', $team);

        $team->learningArtifacts()->detach($learningArtifact);

        return response()->noContent();
    }
}
