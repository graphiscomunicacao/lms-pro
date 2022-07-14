<?php
namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\LearningArtifact;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningArtifactCollection;

class JobLearningArtifactsController extends Controller
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

        $learningArtifacts = $job
            ->learningArtifacts()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningArtifactCollection($learningArtifacts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Job $job,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('update', $job);

        $job->learningArtifacts()->syncWithoutDetaching([
            $learningArtifact->id,
        ]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Job $job,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('update', $job);

        $job->learningArtifacts()->detach($learningArtifact);

        return response()->noContent();
    }
}
