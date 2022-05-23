<?php
namespace App\Http\Controllers\Api;

use App\Models\Job;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobCollection;

class MenuJobsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Menu $menu)
    {
        $this->authorize('view', $menu);

        $search = $request->get('search', '');

        $jobs = $menu
            ->jobs()
            ->search($search)
            ->latest()
            ->paginate();

        return new JobCollection($jobs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Menu $menu, Job $job)
    {
        $this->authorize('update', $menu);

        $menu->jobs()->syncWithoutDetaching([$job->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Menu $menu, Job $job)
    {
        $this->authorize('update', $menu);

        $menu->jobs()->detach($job);

        return response()->noContent();
    }
}
