<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MenuUpdateRequest;

class MenuController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Menu::class);

        $search = $request->get('search', '');

        $menus = Menu::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.menus.index', compact('menus', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Menu::class);

        return view('app.menus.create');
    }

    /**
     * @param \App\Http\Requests\MenuStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {
        $this->authorize('create', Menu::class);

        $validated = $request->validated();
        if ($request->hasFile('cover_path')) {
            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $menu = Menu::create($validated);

        return redirect()
            ->route('menus.edit', $menu)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Menu $menu)
    {
        $this->authorize('view', $menu);

        return view('app.menus.show', compact('menu'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        return view('app.menus.edit', compact('menu'));
    }

    /**
     * @param \App\Http\Requests\MenuUpdateRequest $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        $validated = $request->validated();
        if ($request->hasFile('cover_path')) {
            if ($menu->cover_path) {
                Storage::delete($menu->cover_path);
            }

            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $menu->update($validated);

        return redirect()
            ->route('menus.edit', $menu)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Menu $menu)
    {
        $this->authorize('delete', $menu);

        if ($menu->cover_path) {
            Storage::delete($menu->cover_path);
        }

        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
