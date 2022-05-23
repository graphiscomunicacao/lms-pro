<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Models\LearningPathGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathGroupCollection;

class LearningPathLearningPathGroupsController extends Controller
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

        $learningPathGroups = $learningPath
            ->learningPathGroups()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathGroupCollection($learningPathGroups);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningPath $learningPath,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('update', $learningPath);

        $learningPath
            ->learningPathGroups()
            ->syncWithoutDetaching([$learningPathGroup->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningPath $learningPath,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('update', $learningPath);

        $learningPath->learningPathGroups()->detach($learningPathGroup);

        return response()->noContent();
    }
}
