<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class JobUsersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Job $job)
    {
        $this->authorize('view', $job);

        $search = $request->get('search', '');

        $users = $job
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Job $job)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'role_id' => ['required', 'exists:roles,id'],
            'group_id' => ['required', 'exists:groups,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = $job->users()->create($validated);

        return new UserResource($user);
    }
}
