<?php
namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\LearningArtifact;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobCollection;

class LearningArtifactJobsController extends Controller
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

        $jobs = $learningArtifact
            ->jobs()
            ->search($search)
            ->latest()
            ->paginate();

        return new JobCollection($jobs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningArtifact $learningArtifact,
        Job $job
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact->jobs()->syncWithoutDetaching([$job->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningArtifact $learningArtifact,
        Job $job
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact->jobs()->detach($job);

        return response()->noContent();
    }
}
