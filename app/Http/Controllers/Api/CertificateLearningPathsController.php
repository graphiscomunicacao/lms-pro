<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningPathResource;
use App\Http\Resources\LearningPathCollection;

class CertificateLearningPathsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Certificate $certificate)
    {
        $this->authorize('view', $certificate);

        $search = $request->get('search', '');

        $learningPaths = $certificate
            ->learningPaths()
            ->search($search)
            ->latest()
            ->paginate();

        return new LearningPathCollection($learningPaths);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Certificate $certificate)
    {
        $this->authorize('create', LearningPath::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date'],
            'availability_time' => ['nullable', 'numeric'],
            'cover_path' => ['image', 'max:1024'],
            'tries' => ['required', 'numeric'],
            'passing_score' => ['required', 'numeric'],
            'approval_goal' => ['nullable', 'numeric'],
        ]);

        if ($request->hasFile('cover_path')) {
            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $learningPath = $certificate->learningPaths()->create($validated);

        return new LearningPathResource($learningPath);
    }
}
