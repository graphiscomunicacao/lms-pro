<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupCollection;
use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;

class GroupController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Group::class);

        $search = $request->get('search', '');

        $groups = Group::search($search)
            ->latest()
            ->paginate();

        return new GroupCollection($groups);
    }

    /**
     * @param \App\Http\Requests\GroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStoreRequest $request)
    {
        $this->authorize('create', Group::class);

        $validated = $request->validated();

        $group = Group::create($validated);

        return new GroupResource($group);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Group $group)
    {
        $this->authorize('view', $group);

        return new GroupResource($group);
    }

    /**
     * @param \App\Http\Requests\GroupUpdateRequest $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupUpdateRequest $request, Group $group)
    {
        $this->authorize('update', $group);

        $validated = $request->validated();

        $group->update($validated);

        return new GroupResource($group);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Group $group)
    {
        $this->authorize('delete', $group);

        $group->delete();

        return response()->noContent();
    }
}
