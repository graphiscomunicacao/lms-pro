<?php
namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\LearningPathGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobCollection;

class LearningPathGroupJobsController extends Controller
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

        $jobs = $learningPathGroup
            ->jobs()
            ->search($search)
            ->latest()
            ->paginate();

        return new JobCollection($jobs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningPathGroup $learningPathGroup,
        Job $job
    ) {
        $this->authorize('update', $learningPathGroup);

        $learningPathGroup->jobs()->syncWithoutDetaching([$job->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningPathGroup $learningPathGroup,
        Job $job
    ) {
        $this->authorize('update', $learningPathGroup);

        $learningPathGroup->jobs()->detach($job);

        return response()->noContent();
    }
}
