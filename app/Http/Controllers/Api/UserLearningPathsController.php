<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathCollection;

class UserLearningPathsController extends Controller
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

        $learningPaths = $user
            ->learningPaths()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathCollection($learningPaths);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        User $user,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $user);

        $user->learningPaths()->syncWithoutDetaching([$learningPath->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        User $user,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $user);

        $user->learningPaths()->detach($learningPath);

        return response()->noContent();
    }
}
