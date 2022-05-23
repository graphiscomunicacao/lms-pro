<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathGroupResultResource;
use App\Http\Resources\LearningPathGroupResultCollection;

class UserLearningPathGroupResultsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $learningPathGroupResults = $user
            ->learningPathGroupResults()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathGroupResultCollection($learningPathGroupResults);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', LearningPathGroupResult::class);

        $validated = $request->validate([
            'submited_at' => ['required', 'date'],
            'score' => ['required', 'numeric'],
            'learning_path_group_id' => [
                'required',
                'exists:learning_path_groups,id',
            ],
        ]);

        $learningPathGroupResult = $user
            ->learningPathGroupResults()
            ->create($validated);

        return new LearningPathGroupResultResource($learningPathGroupResult);
    }
}
