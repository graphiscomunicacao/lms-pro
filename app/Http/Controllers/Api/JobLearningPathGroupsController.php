<?php
namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\LearningPathGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathGroupCollection;

class JobLearningPathGroupsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Job $job)
    {
        $this->authorize('view', $job);

        $search = $request->get('search', '');

        $learningPathGroups = $job
            ->learningPathGroups()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathGroupCollection($learningPathGroups);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Job $job,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('update', $job);

        $job->learningPathGroups()->syncWithoutDetaching([
            $learningPathGroup->id,
        ]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Job $job,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('update', $job);

        $job->learningPathGroups()->detach($learningPathGroup);

        return response()->noContent();
    }
}
