<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Models\LearningPathGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathCollection;

class LearningPathGroupLearningPathsController extends Controller
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

        $learningPaths = $learningPathGroup
            ->learningPaths()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathCollection($learningPaths);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningPathGroup $learningPathGroup,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $learningPathGroup);

        $learningPathGroup
            ->learningPaths()
            ->syncWithoutDetaching([$learningPath->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningPathGroup $learningPathGroup,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $learningPathGroup);

        $learningPathGroup->learningPaths()->detach($learningPath);

        return response()->noContent();
    }
}
