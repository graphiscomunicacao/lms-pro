<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', User::class);

        $search = $request->get('search', '');

        $users = User::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.users.index', compact('users', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', User::class);

        $roles = Role::pluck('name', 'id');
        $jobs = Job::pluck('name', 'id');
        $groups = Group::pluck('name', 'id');

        return view('app.users.create', compact('roles', 'jobs', 'groups'));
    }

    /**
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->authorize('view', $user);

        return view('app.users.show', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $roles = Role::pluck('name', 'id');
        $jobs = Job::pluck('name', 'id');
        $groups = Group::pluck('name', 'id');

        return view(
            'app.users.edit',
            compact('user', 'roles', 'jobs', 'groups')
        );
    }

    /**
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
