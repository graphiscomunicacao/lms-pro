<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\LearningPathGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathGroupResource;
use App\Http\Resources\LearningPathGroupCollection;
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
            ->paginate();

        return new LearningPathGroupCollection($learningPathGroups);
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

        return new LearningPathGroupResource($learningPathGroup);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, LearningPathGroup $learningPathGroup)
    {
        $this->authorize('view', $learningPathGroup);

        return new LearningPathGroupResource($learningPathGroup);
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

        return new LearningPathGroupResource($learningPathGroup);
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

        return response()->noContent();
    }
}
