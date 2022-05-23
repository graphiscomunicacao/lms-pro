<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningArtifactResource;
use App\Http\Resources\LearningArtifactCollection;

class UserLearningArtifactsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $learningArtifacts = $user
            ->learningArtifacts()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningArtifactCollection($learningArtifacts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', LearningArtifact::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'type' => [
                'required',
                'in:audio,document,interactive,image,video,externo',
            ],
            'size' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            'external' => ['required', 'boolean'],
            'url' => ['nullable', 'url'],
            'path' => ['file', 'max:5000'],
        ]);

        if ($request->hasFile('path')) {
            $validated['path'] = $request->file('path')->store('public');
        }

        $learningArtifact = $user->learningArtifacts()->create($validated);

        return new LearningArtifactResource($learningArtifact);
    }
}
