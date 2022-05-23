<?php
namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizCollection;

class MenuQuizzesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Menu $menu)
    {
        $this->authorize('view', $menu);

        $search = $request->get('search', '');

        $quizzes = $menu
            ->quizzes()
            ->search($search)
            ->latest()
            ->paginate();

        return new QuizCollection($quizzes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Menu $menu, Quiz $quiz)
    {
        $this->authorize('update', $menu);

        $menu->quizzes()->syncWithoutDetaching([$quiz->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Menu $menu, Quiz $quiz)
    {
        $this->authorize('update', $menu);

        $menu->quizzes()->detach($quiz);

        return response()->noContent();
    }
}
