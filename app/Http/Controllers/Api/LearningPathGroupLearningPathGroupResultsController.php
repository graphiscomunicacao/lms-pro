<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\LearningPathGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathGroupResultResource;
use App\Http\Resources\LearningPathGroupResultCollection;

class LearningPathGroupLearningPathGroupResultsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('view', $learningPathGroup);

        $search = $request->get('search', '');

        $learningPathGroupResults = $learningPathGroup
            ->learningPathGroupResults()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathGroupResultCollection($learningPathGroupResults);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPathGroup $learningPathGroup
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningPathGroup $learningPathGroup
    ) {
        $this->authorize('create', LearningPathGroupResult::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'submited_at' => ['required', 'date'],
            'score' => ['required', 'numeric'],
        ]);

        $learningPathGroupResult = $learningPathGroup
            ->learningPathGroupResults()
            ->create($validated);

        return new LearningPathGroupResultResource($learningPathGroupResult);
    }
}
