<?php
namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathCollection;

class JobLearningPathsController extends Controller
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

        $learningPaths = $job
            ->learningPaths()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathCollection($learningPaths);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Job $job,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $job);

        $job->learningPaths()->syncWithoutDetaching([$learningPath->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Job $job,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $job);

        $job->learningPaths()->detach($learningPath);

        return response()->noContent();
    }
}
