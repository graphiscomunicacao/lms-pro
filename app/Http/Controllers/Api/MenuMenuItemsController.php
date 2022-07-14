<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemResource;
use App\Http\Resources\MenuItemCollection;

class MenuMenuItemsController extends Controller
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

        $menuItems = $menu
            ->menuItems()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuItemCollection($menuItems);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Menu $menu)
    {
        $this->authorize('create', MenuItem::class);

        $validated = $request->validate([
            'item_type' => ['required', 'max:255', 'string'],
            'item_id' => ['required', 'numeric'],
            'order' => ['required', 'numeric'],
        ]);

        $menuItem = $menu->menuItems()->create($validated);

        return new MenuItemResource($menuItem);
    }
}
