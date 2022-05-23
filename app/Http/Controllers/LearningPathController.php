<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\LearningPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\LearningPathStoreRequest;
use App\Http\Requests\LearningPathUpdateRequest;

class LearningPathController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', LearningPath::class);

        $search = $request->get('search', '');

        $learningPaths = LearningPath::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.learning_paths.index',
            compact('learningPaths', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', LearningPath::class);

        $certificates = Certificate::pluck('name', 'id');

        return view('app.learning_paths.create', compact('certificates'));
    }

    /**
     * @param \App\Http\Requests\LearningPathStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LearningPathStoreRequest $request)
    {
        $this->authorize('create', LearningPath::class);

        $validated = $request->validated();
        if ($request->hasFile('cover_path')) {
            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $learningPath = LearningPath::create($validated);

        return redirect()
            ->route('learning-paths.edit', $learningPath)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, LearningPath $learningPath)
    {
        $this->authorize('view', $learningPath);

        return view('app.learning_paths.show', compact('learningPath'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, LearningPath $learningPath)
    {
        $this->authorize('update', $learningPath);

        $certificates = Certificate::pluck('name', 'id');

        return view(
            'app.learning_paths.edit',
            compact('learningPath', 'certificates')
        );
    }

    /**
     * @param \App\Http\Requests\LearningPathUpdateRequest $request
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function update(
        LearningPathUpdateRequest $request,
        LearningPath $learningPath
    ) {
        $this->authorize('update', $learningPath);

        $validated = $request->validated();
        if ($request->hasFile('cover_path')) {
            if ($learningPath->cover_path) {
                Storage::delete($learningPath->cover_path);
            }

            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $learningPath->update($validated);

        return redirect()
            ->route('learning-paths.edit', $learningPath)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LearningPath $learningPath)
    {
        $this->authorize('delete', $learningPath);

        if ($learningPath->cover_path) {
            Storage::delete($learningPath->cover_path);
        }

        $learningPath->delete();

        return redirect()
            ->route('learning-paths.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
