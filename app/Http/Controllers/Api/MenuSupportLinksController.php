<?php
namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\SupportLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupportLinkCollection;

class MenuSupportLinksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Menu $menu)
    {
        $this->authorize('view', $menu);

        $search = $request->get('search', '');

        $supportLinks = $menu
            ->supportLinks()
            ->search($search)
            ->latest()
            ->paginate();

        return new SupportLinkCollection($supportLinks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Menu $menu,
        SupportLink $supportLink
    ) {
        $this->authorize('update', $menu);

        $menu->supportLinks()->syncWithoutDetaching([$supportLink->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Menu $menu,
        SupportLink $supportLink
    ) {
        $this->authorize('update', $menu);

        $menu->supportLinks()->detach($supportLink);

        return response()->noContent();
    }
}
