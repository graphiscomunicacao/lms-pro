<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.menu_items.index', compact('menuItems', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', MenuItem::class);

        $menus = Menu::pluck('name', 'id');

        return view('app.menu_items.create', compact('menus'));
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

        return redirect()
            ->route('menu-items.edit', $menuItem)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MenuItem $menuItem)
    {
        $this->authorize('view', $menuItem);

        return view('app.menu_items.show', compact('menuItem'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MenuItem $menuItem)
    {
        $this->authorize('update', $menuItem);

        $menus = Menu::pluck('name', 'id');

        return view('app.menu_items.edit', compact('menuItem', 'menus'));
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

        return redirect()
            ->route('menu-items.edit', $menuItem)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('menu-items.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
