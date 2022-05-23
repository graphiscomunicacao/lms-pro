<?php
namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class QuizCategoriesController extends Controller
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

        $categories = $quiz
            ->categories()
            ->search($search)
            ->latest()
            ->paginate();

        return new CategoryCollection($categories);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quiz $quiz, Category $category)
    {
        $this->authorize('update', $quiz);

        $quiz->categories()->syncWithoutDetaching([$category->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Quiz $quiz, Category $category)
    {
        $this->authorize('update', $quiz);

        $quiz->categories()->detach($category);

        return response()->noContent();
    }
}
