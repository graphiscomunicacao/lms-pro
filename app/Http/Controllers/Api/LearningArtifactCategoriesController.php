<?php
namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\LearningArtifact;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class LearningArtifactCategoriesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LearningArtifact $learningArtifact)
    {
        $this->authorize('view', $learningArtifact);

        $search = $request->get('search', '');

        $categories = $learningArtifact
            ->categories()
            ->search($search)
            ->latest()
            ->paginate();

        return new CategoryCollection($categories);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningArtifact $learningArtifact,
        Category $category
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact->categories()->syncWithoutDetaching([$category->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningArtifact $learningArtifact,
        Category $category
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact->categories()->detach($category);

        return response()->noContent();
    }
}
