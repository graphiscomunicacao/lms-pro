<?php
namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobCollection;

class LearningPathJobsController extends Controller
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

        $jobs = $learningPath
            ->jobs()
            ->search($search)
            ->latest()
            ->paginate();

        return new JobCollection($jobs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningPath $learningPath,
        Job $job
    ) {
        $this->authorize('update', $learningPath);

        $learningPath->jobs()->syncWithoutDetaching([$job->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningPath $learningPath,
        Job $job
    ) {
        $this->authorize('update', $learningPath);

        $learningPath->jobs()->detach($job);

        return response()->noContent();
    }
}
