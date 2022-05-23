<?php
namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizCollection;

class CategoryQuizzesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        $this->authorize('view', $category);

        $search = $request->get('search', '');

        $quizzes = $category
            ->quizzes()
            ->search($search)
            ->latest()
            ->paginate();

        return new QuizCollection($quizzes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category, Quiz $quiz)
    {
        $this->authorize('update', $category);

        $category->quizzes()->syncWithoutDetaching([$quiz->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category, Quiz $quiz)
    {
        $this->authorize('update', $category);

        $category->quizzes()->detach($quiz);

        return response()->noContent();
    }
}
