<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Models\LearningArtifact;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathCollection;

class LearningArtifactLearningPathsController extends Controller
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

        $learningPaths = $learningArtifact
            ->learningPaths()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathCollection($learningPaths);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningArtifact $learningArtifact,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact
            ->learningPaths()
            ->syncWithoutDetaching([$learningPath->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningArtifact $learningArtifact,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact->learningPaths()->detach($learningPath);

        return response()->noContent();
    }
}
