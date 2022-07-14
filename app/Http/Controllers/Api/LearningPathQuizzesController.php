<?php
namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizCollection;

class LearningPathQuizzesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LearningPath $learningPath)
    {
        $this->authorize('view', $learningPath);

        $search = $request->get('search', '');

        $quizzes = $learningPath
            ->quizzes()
            ->search($search)
            ->latest()
            ->paginate();

        return new QuizCollection($quizzes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningPath $learningPath,
        Quiz $quiz
    ) {
        $this->authorize('update', $learningPath);

        $learningPath->quizzes()->syncWithoutDetaching([$quiz->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningPath $learningPath,
        Quiz $quiz
    ) {
        $this->authorize('update', $learningPath);

        $learningPath->quizzes()->detach($quiz);

        return response()->noContent();
    }
}
