<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningPathGroup;
use App\Http\Requests\LearningPathGroupStoreRequest;
use App\Http\Requests\LearningPathGroupUpdateRequest;

class LearningPathGroupController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', LearningPathGroup::class);

        $search = $request->get('search', '');

        $learningPathGroups = LearningPathGroup::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.learning_path_groups.index',
            compact('learningPathGroups', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', LearningPathGroup::class);

        return view('app.learning_path_groups.create');
    }

    /**
     * @param \App\Http\Requests\LearningPathGroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LearningPathGroupStoreRequest $request)
    {
        $this->authorize('create', LearningPathGroup::class);

        $validated = $request->validated();

        $learningPathGroup = LearningPathGroup::create($validated);

        return redirect()
            ->route('learning-path-groups.edit', $learningPathGroup)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, LearningPathGroup $learningPathGroup)
    {
        $this->authorize('view', $learningPathGroup);

        return view(
            'app.learning_path_groups.show',
            compact('learningPathGroup')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, LearningPathGroup $learningPathGroup)
    {
        $this->authorize('update', $learningPathGroup);

        return view(
            'app.learning_path_groups.edit',
            compact('learningPathGroup')
        );
    }

    /**
     * @param \App\Http\Requests\LearningPathGroupUpdateRequest $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function update(
        LearningPathGroupUpdateRequest $request,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('update', $learningPathGroup);

        $validated = $request->validated();

        $learningPathGroup->update($validated);

        return redirect()
            ->route('learning-path-groups.edit', $learningPathGroup)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('delete', $learningPathGroup);

        $learningPathGroup->delete();

        return redirect()
            ->route('learning-path-groups.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
