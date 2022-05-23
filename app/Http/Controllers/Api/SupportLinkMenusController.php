<?php
namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\SupportLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class SupportLinkMenusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SupportLink $supportLink)
    {
        $this->authorize('view', $supportLink);

        $search = $request->get('search', '');

        $menus = $supportLink
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupportLink $supportLink
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        SupportLink $supportLink,
        Menu $menu
    ) {
        $this->authorize('update', $supportLink);

        $supportLink->menus()->syncWithoutDetaching([$menu->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupportLink $supportLink
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SupportLink $supportLink,
        Menu $menu
    ) {
        $this->authorize('update', $supportLink);

        $supportLink->menus()->detach($menu);

        return response()->noContent();
    }
}
