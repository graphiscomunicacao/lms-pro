<?php
namespace App\Http\Controllers\Api;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\LearningArtifact;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamCollection;

class LearningArtifactTeamsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LearningArtifact $learningArtifact)
    {
        $this->authorize('view', $learningArtifact);

        $search = $request->get('search', '');

        $teams = $learningArtifact
            ->teams()
            ->search($search)
            ->latest()
            ->paginate();

        return new TeamCollection($teams);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningArtifact $learningArtifact,
        Team $team
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact->teams()->syncWithoutDetaching([$team->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningArtifact $learningArtifact,
        Team $team
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact->teams()->detach($team);

        return response()->noContent();
    }
}
