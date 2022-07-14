<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResultResource;
use App\Http\Resources\QuizResultCollection;

class UserQuizResultsController extends Controller
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

        $quizResults = $user
            ->quizResults()
            ->search($search)
            ->latest()
            ->paginate();

        return new QuizResultCollection($quizResults);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', QuizResult::class);

        $validated = $request->validate([
            'quiz_id' => ['required', 'exists:quizzes,id'],
            'submited_at' => ['required', 'date'],
            'result' => ['required', 'numeric'],
        ]);

        $quizResult = $user->quizResults()->create($validated);

        return new QuizResultResource($quizResult);
    }
}
