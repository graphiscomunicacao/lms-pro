<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.groups.index', compact('groups', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Group::class);

        return view('app.groups.create');
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

        return redirect()
            ->route('groups.edit', $group)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Group $group)
    {
        $this->authorize('view', $group);

        return view('app.groups.show', compact('group'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Group $group)
    {
        $this->authorize('update', $group);

        return view('app.groups.edit', compact('group'));
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

        return redirect()
            ->route('groups.edit', $group)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('groups.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
