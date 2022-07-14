<?php

namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Resources\QuizResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizCollection;
use App\Http\Requests\QuizStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\QuizUpdateRequest;

class QuizController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Quiz::class);

        $search = $request->get('search', '');

        $quizzes = Quiz::search($search)
            ->latest()
            ->paginate();

        return new QuizCollection($quizzes);
    }

    /**
     * @param \App\Http\Requests\QuizStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizStoreRequest $request)
    {
        $this->authorize('create', Quiz::class);

        $validated = $request->validated();
        if ($request->hasFile('cover_path')) {
            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $quiz = Quiz::create($validated);

        return new QuizResource($quiz);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Quiz $quiz)
    {
        $this->authorize('view', $quiz);

        return new QuizResource($quiz);
    }

    /**
     * @param \App\Http\Requests\QuizUpdateRequest $request
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(QuizUpdateRequest $request, Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $validated = $request->validated();

        if ($request->hasFile('cover_path')) {
            if ($quiz->cover_path) {
                Storage::delete($quiz->cover_path);
            }

            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $quiz->update($validated);

        return new QuizResource($quiz);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Quiz $quiz)
    {
        $this->authorize('delete', $quiz);

        if ($quiz->cover_path) {
            Storage::delete($quiz->cover_path);
        }

        $quiz->delete();

        return response()->noContent();
    }
}
