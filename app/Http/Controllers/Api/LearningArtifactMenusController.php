<?php
namespace App\Http\Controllers\Api;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\LearningArtifact;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class LearningArtifactMenusController extends Controller
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

        $menus = $learningArtifact
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LearningArtifact $learningArtifact,
        Menu $menu
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact->menus()->syncWithoutDetaching([$menu->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningArtifact $learningArtifact,
        Menu $menu
    ) {
        $this->authorize('update', $learningArtifact);

        $learningArtifact->menus()->detach($menu);

        return response()->noContent();
    }
}
