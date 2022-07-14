<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MenuItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the menuItem can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the menuItem can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuItem  $model
     * @return mixed
     */
    public function view(User $user, MenuItem $model)
    {
        return true;
    }

    /**
     * Determine whether the menuItem can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the menuItem can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuItem  $model
     * @return mixed
     */
    public function update(User $user, MenuItem $model)
    {
        return true;
    }

    /**
     * Determine whether the menuItem can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuItem  $model
     * @return mixed
     */
    public function delete(User $user, MenuItem $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuItem  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the menuItem can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuItem  $model
     * @return mixed
     */
    public function restore(User $user, MenuItem $model)
    {
        return false;
    }

    /**
     * Determine whether the menuItem can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuItem  $model
     * @return mixed
     */
    public function forceDelete(User $user, MenuItem $model)
    {
        return false;
    }
}
