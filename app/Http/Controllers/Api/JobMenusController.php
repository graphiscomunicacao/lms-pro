<?php
namespace App\Http\Controllers\Api;

use App\Models\Job;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class JobMenusController extends Controller
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

        $menus = $job
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Job $job, Menu $menu)
    {
        $this->authorize('update', $job);

        $job->menus()->syncWithoutDetaching([$menu->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Job $job, Menu $menu)
    {
        $this->authorize('update', $job);

        $job->menus()->detach($menu);

        return response()->noContent();
    }
}
