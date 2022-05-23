<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Category::class);

        $search = $request->get('search', '');

        $categories = Category::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.categories.index', compact('categories', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Category::class);

        return view('app.categories.create');
    }

    /**
     * @param \App\Http\Requests\CategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $this->authorize('create', Category::class);

        $validated = $request->validated();
        if ($request->hasFile('cover_path')) {
            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $category = Category::create($validated);

        return redirect()
            ->route('categories.edit', $category)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Category $category)
    {
        $this->authorize('view', $category);

        return view('app.categories.show', compact('category'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        return view('app.categories.edit', compact('category'));
    }

    /**
     * @param \App\Http\Requests\CategoryUpdateRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validated();
        if ($request->hasFile('cover_path')) {
            if ($category->cover_path) {
                Storage::delete($category->cover_path);
            }

            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $category->update($validated);

        return redirect()
            ->route('categories.edit', $category)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        $this->authorize('delete', $category);

        if ($category->cover_path) {
            Storage::delete($category->cover_path);
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
