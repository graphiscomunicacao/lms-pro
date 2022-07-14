<?php
namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\ObjectiveQuestion;
use App\Http\Controllers\Controller;
use App\Http\Resources\ObjectiveQuestionCollection;

class QuizObjectiveQuestionsController extends Controller
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

        $objectiveQuestions = $quiz
            ->objectiveQuestions()
            ->search($search)
            ->latest()
            ->paginate();

        return new ObjectiveQuestionCollection($objectiveQuestions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\ObjectiveQuestion $objectiveQuestion
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Quiz $quiz,
        ObjectiveQuestion $objectiveQuestion
    ) {
        $this->authorize('update', $quiz);

        $quiz
            ->objectiveQuestions()
            ->syncWithoutDetaching([$objectiveQuestion->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\ObjectiveQuestion $objectiveQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Quiz $quiz,
        ObjectiveQuestion $objectiveQuestion
    ) {
        $this->authorize('update', $quiz);

        $quiz->objectiveQuestions()->detach($objectiveQuestion);

        return response()->noContent();
    }
}
