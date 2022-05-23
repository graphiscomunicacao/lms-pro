<?php
namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ObjectiveQuestion;
use App\Http\Controllers\Controller;
use App\Http\Resources\ObjectiveQuestionCollection;

class CategoryObjectiveQuestionsController extends Controller
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

        $objectiveQuestions = $category
            ->objectiveQuestions()
            ->search($search)
            ->latest()
            ->paginate();

        return new ObjectiveQuestionCollection($objectiveQuestions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\ObjectiveQuestion $objectiveQuestion
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Category $category,
        ObjectiveQuestion $objectiveQuestion
    ) {
        $this->authorize('update', $category);

        $category
            ->objectiveQuestions()
            ->syncWithoutDetaching([$objectiveQuestion->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\ObjectiveQuestion $objectiveQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Category $category,
        ObjectiveQuestion $objectiveQuestion
    ) {
        $this->authorize('update', $category);

        $category->objectiveQuestions()->detach($objectiveQuestion);

        return response()->noContent();
    }
}
