<?php
namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\SupportLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupportLinkCollection;

class CategorySupportLinksController extends Controller
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

        $supportLinks = $category
            ->supportLinks()
            ->search($search)
            ->latest()
            ->paginate();

        return new SupportLinkCollection($supportLinks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Category $category,
        SupportLink $supportLink
    ) {
        $this->authorize('update', $category);

        $category->supportLinks()->syncWithoutDetaching([$supportLink->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Category $category,
        SupportLink $supportLink
    ) {
        $this->authorize('update', $category);

        $category->supportLinks()->detach($supportLink);

        return response()->noContent();
    }
}
