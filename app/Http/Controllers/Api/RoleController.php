<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
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
            ->paginate();

        return new RoleCollection($roles);
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

        return new RoleResource($role);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Role $role)
    {
        $this->authorize('view', $role);

        return new RoleResource($role);
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

        return new RoleResource($role);
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

        return response()->noContent();
    }
}
