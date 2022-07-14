<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceDetailResource;
use App\Http\Resources\ExperienceDetailCollection;

class UserExperienceDetailsController extends Controller
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

        $experienceDetails = $user
            ->experienceDetails()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExperienceDetailCollection($experienceDetails);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', ExperienceDetail::class);

        $validated = $request->validate([
            'experience_amount' => ['required', 'numeric'],
            'is_double' => ['required', 'boolean'],
            'type' => [
                'required',
                'in:learningartifact,quiz,learningpath,learningpathgroup',
            ],
            'item_id' => ['required', 'numeric'],
        ]);

        $experienceDetail = $user->experienceDetails()->create($validated);

        return new ExperienceDetailResource($experienceDetail);
    }
}
