<?php
namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathCollection;

class QuizLearningPathsController extends Controller
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

        $learningPaths = $quiz
            ->learningPaths()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathCollection($learningPaths);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Quiz $quiz,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $quiz);

        $quiz->learningPaths()->syncWithoutDetaching([$learningPath->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Quiz $quiz,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $quiz);

        $quiz->learningPaths()->detach($learningPath);

        return response()->noContent();
    }
}
