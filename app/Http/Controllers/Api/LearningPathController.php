<?php

namespace App\Http\Controllers\Api;

use App\Models\LearningPath;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\LearningPathResource;
use App\Http\Resources\LearningPathCollection;
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
            ->paginate();

        return new LearningPathCollection($learningPaths);
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

        return new LearningPathResource($learningPath);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningPath $learningPath
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, LearningPath $learningPath)
    {
        $this->authorize('view', $learningPath);

        return new LearningPathResource($learningPath);
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

        return new LearningPathResource($learningPath);
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

        return response()->noContent();
    }
}
