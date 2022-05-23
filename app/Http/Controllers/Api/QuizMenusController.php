<?php
namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class QuizMenusController extends Controller
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

        $menus = $quiz
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quiz $quiz, Menu $menu)
    {
        $this->authorize('update', $quiz);

        $quiz->menus()->syncWithoutDetaching([$menu->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Quiz $quiz, Menu $menu)
    {
        $this->authorize('update', $quiz);

        $quiz->menus()->detach($menu);

        return response()->noContent();
    }
}
