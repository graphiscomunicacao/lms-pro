<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the role can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the role can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Role  $model
     * @return mixed
     */
    public function view(User $user, Role $model)
    {
        return true;
    }

    /**
     * Determine whether the role can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the role can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Role  $model
     * @return mixed
     */
    public function update(User $user, Role $model)
    {
        return true;
    }

    /**
     * Determine whether the role can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Role  $model
     * @return mixed
     */
    public function delete(User $user, Role $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Role  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the role can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Role  $model
     * @return mixed
     */
    public function restore(User $user, Role $model)
    {
        return false;
    }

    /**
     * Determine whether the role can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Role  $model
     * @return mixed
     */
    public function forceDelete(User $user, Role $model)
    {
        return false;
    }
}
