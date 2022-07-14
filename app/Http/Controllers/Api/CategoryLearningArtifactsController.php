<?php
namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\LearningArtifact;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningArtifactCollection;

class CategoryLearningArtifactsController extends Controller
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

        $learningArtifacts = $category
            ->learningArtifacts()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningArtifactCollection($learningArtifacts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Category $category,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('update', $category);

        $category
            ->learningArtifacts()
            ->syncWithoutDetaching([$learningArtifact->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Category $category,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('update', $category);

        $category->learningArtifacts()->detach($learningArtifact);

        return response()->noContent();
    }
}
