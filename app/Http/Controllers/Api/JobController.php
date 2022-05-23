<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobCollection;
use App\Http\Requests\JobStoreRequest;
use App\Http\Requests\JobUpdateRequest;

class JobController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Job::class);

        $search = $request->get('search', '');

        $jobs = Job::search($search)
            ->latest()
            ->paginate();

        return new JobCollection($jobs);
    }

    /**
     * @param \App\Http\Requests\JobStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobStoreRequest $request)
    {
        $this->authorize('create', Job::class);

        $validated = $request->validated();

        $job = Job::create($validated);

        return new JobResource($job);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Job $job)
    {
        $this->authorize('view', $job);

        return new JobResource($job);
    }

    /**
     * @param \App\Http\Requests\JobUpdateRequest $request
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function update(JobUpdateRequest $request, Job $job)
    {
        $this->authorize('update', $job);

        $validated = $request->validated();

        $job->update($validated);

        return new JobResource($job);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Job $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return response()->noContent();
    }
}
