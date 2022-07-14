<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ObjectiveAnswerResource;
use App\Http\Resources\ObjectiveAnswerCollection;

class UserObjectiveAnswersController extends Controller
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

        $objectiveAnswers = $user
            ->objectiveAnswers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ObjectiveAnswerCollection($objectiveAnswers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', ObjectiveAnswer::class);

        $validated = $request->validate([
            'objective_question_id' => [
                'required',
                'exists:objective_questions,id',
            ],
            'objective_question_option_id' => [
                'required',
                'exists:objective_question_options,id',
            ],
            'is_correct' => ['required', 'boolean'],
            'time_spent' => ['required', 'numeric'],
        ]);

        $objectiveAnswer = $user->objectiveAnswers()->create($validated);

        return new ObjectiveAnswerResource($objectiveAnswer);
    }
}
