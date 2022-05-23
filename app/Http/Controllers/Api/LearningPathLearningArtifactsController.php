<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Models\LearningArtifact;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningArtifactCollection;

class LearningPathLearningArtifactsController extends Controller
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

        $learningArtifacts = $learningPath
            ->learningArtifacts()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningArtifactCollection($learningArtifacts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningPath $learningPath,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('update', $learningPath);

        $learningPath
            ->learningArtifacts()
            ->syncWithoutDetaching([$learningArtifact->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningPath $learningPath,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('update', $learningPath);

        $learningPath->learningArtifacts()->detach($learningArtifact);

        return response()->noContent();
    }
}
