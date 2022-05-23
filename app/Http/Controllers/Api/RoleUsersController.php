<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class RoleUsersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Role $role)
    {
        $this->authorize('view', $role);

        $search = $request->get('search', '');

        $users = $role
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Role $role)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'job_id' => ['required', 'exists:jobs,id'],
            'group_id' => ['required', 'exists:groups,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = $role->users()->create($validated);

        return new UserResource($user);
    }
}
