<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningArtifact;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\LearningArtifactStoreRequest;
use App\Http\Requests\LearningArtifactUpdateRequest;

class LearningArtifactController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', LearningArtifact::class);

        $search = $request->get('search', '');

        $learningArtifacts = LearningArtifact::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.learning_artifacts.index',
            compact('learningArtifacts', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', LearningArtifact::class);

        return view('app.learning_artifacts.create');
    }

    /**
     * @param \App\Http\Requests\LearningArtifactStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LearningArtifactStoreRequest $request)
    {
        $this->authorize('create', LearningArtifact::class);

        $validated = $request->validated();
        if ($request->hasFile('path')) {
            $validated['path'] = $request->file('path')->store('public');
        }

        $learningArtifact = LearningArtifact::create($validated);

        return redirect()
            ->route('learning-artifacts.edit', $learningArtifact)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, LearningArtifact $learningArtifact)
    {
        $this->authorize('view', $learningArtifact);

        return view('app.learning_artifacts.show', compact('learningArtifact'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, LearningArtifact $learningArtifact)
    {
        $this->authorize('update', $learningArtifact);

        return view('app.learning_artifacts.edit', compact('learningArtifact'));
    }

    /**
     * @param \App\Http\Requests\LearningArtifactUpdateRequest $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function update(
        LearningArtifactUpdateRequest $request,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('update', $learningArtifact);

        $validated = $request->validated();
        if ($request->hasFile('path')) {
            if ($learningArtifact->path) {
                Storage::delete($learningArtifact->path);
            }

            $validated['path'] = $request->file('path')->store('public');
        }

        $learningArtifact->update($validated);

        return redirect()
            ->route('learning-artifacts.edit', $learningArtifact)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LearningArtifact $learningArtifact
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LearningArtifact $learningArtifact
    ) {
        $this->authorize('delete', $learningArtifact);

        if ($learningArtifact->path) {
            Storage::delete($learningArtifact->path);
        }

        $learningArtifact->delete();

        return redirect()
            ->route('learning-artifacts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
