<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemResource;
use App\Http\Resources\MenuItemCollection;
use App\Http\Requests\MenuItemStoreRequest;
use App\Http\Requests\MenuItemUpdateRequest;

class MenuItemController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MenuItem::class);

        $search = $request->get('search', '');

        $menuItems = MenuItem::search($search)
            ->latest()
            ->paginate();

        return new MenuItemCollection($menuItems);
    }

    /**
     * @param \App\Http\Requests\MenuItemStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuItemStoreRequest $request)
    {
        $this->authorize('create', MenuItem::class);

        $validated = $request->validated();

        $menuItem = MenuItem::create($validated);

        return new MenuItemResource($menuItem);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MenuItem $menuItem)
    {
        $this->authorize('view', $menuItem);

        return new MenuItemResource($menuItem);
    }

    /**
     * @param \App\Http\Requests\MenuItemUpdateRequest $request
     * @param \App\Models\MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function update(MenuItemUpdateRequest $request, MenuItem $menuItem)
    {
        $this->authorize('update', $menuItem);

        $validated = $request->validated();

        $menuItem->update($validated);

        return new MenuItemResource($menuItem);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MenuItem $menuItem)
    {
        $this->authorize('delete', $menuItem);

        $menuItem->delete();

        return response()->noContent();
    }
}
