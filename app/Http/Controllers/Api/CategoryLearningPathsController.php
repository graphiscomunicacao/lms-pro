<?php
namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathCollection;

class CategoryLearningPathsController extends Controller
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

        $learningPaths = $category
            ->learningPaths()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathCollection($learningPaths);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Category $category,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $category);

        $category->learningPaths()->syncWithoutDetaching([$learningPath->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Category $category,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $category);

        $category->learningPaths()->detach($learningPath);

        return response()->noContent();
    }
}
