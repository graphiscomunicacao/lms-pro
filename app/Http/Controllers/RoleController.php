<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

class RoleController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Role::class);

        $search = $request->get('search', '');

        $roles = Role::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.roles.index', compact('roles', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Role::class);

        return view('app.roles.create');
    }

    /**
     * @param \App\Http\Requests\RoleStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $this->authorize('create', Role::class);

        $validated = $request->validated();

        $role = Role::create($validated);

        return redirect()
            ->route('roles.edit', $role)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Role $role)
    {
        $this->authorize('view', $role);

        return view('app.roles.show', compact('role'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        return view('app.roles.edit', compact('role'));
    }

    /**
     * @param \App\Http\Requests\RoleUpdateRequest $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        $validated = $request->validated();

        $role->update($validated);

        return redirect()
            ->route('roles.edit', $role)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        $this->authorize('delete', $role);

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
