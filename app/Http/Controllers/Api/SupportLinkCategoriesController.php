<?php
namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\SupportLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class SupportLinkCategoriesController extends Controller
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

        $categories = $supportLink
            ->categories()
            ->search($search)
            ->latest()
            ->paginate();

        return new CategoryCollection($categories);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupportLink $supportLink
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        SupportLink $supportLink,
        Category $category
    ) {
        $this->authorize('update', $supportLink);

        $supportLink->categories()->syncWithoutDetaching([$category->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupportLink $supportLink
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SupportLink $supportLink,
        Category $category
    ) {
        $this->authorize('update', $supportLink);

        $supportLink->categories()->detach($category);

        return response()->noContent();
    }
}
