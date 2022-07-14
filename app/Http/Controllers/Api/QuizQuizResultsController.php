<?php

namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResultResource;
use App\Http\Resources\QuizResultCollection;

class QuizQuizResultsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Quiz $quiz)
    {
        $this->authorize('view', $quiz);

        $search = $request->get('search', '');

        $quizResults = $quiz
            ->quizResults()
            ->search($search)
            ->latest()
            ->paginate();

        return new QuizResultCollection($quizResults);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quiz $quiz)
    {
        $this->authorize('create', QuizResult::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'submited_at' => ['required', 'date'],
            'result' => ['required', 'numeric'],
        ]);

        $quizResult = $quiz->quizResults()->create($validated);

        return new QuizResultResource($quizResult);
    }
}
