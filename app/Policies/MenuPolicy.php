<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the menu can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the menu can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Menu  $model
     * @return mixed
     */
    public function view(User $user, Menu $model)
    {
        return true;
    }

    /**
     * Determine whether the menu can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the menu can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Menu  $model
     * @return mixed
     */
    public function update(User $user, Menu $model)
    {
        return true;
    }

    /**
     * Determine whether the menu can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Menu  $model
     * @return mixed
     */
    public function delete(User $user, Menu $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Menu  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the menu can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Menu  $model
     * @return mixed
     */
    public function restore(User $user, Menu $model)
    {
        return false;
    }

    /**
     * Determine whether the menu can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Menu  $model
     * @return mixed
     */
    public function forceDelete(User $user, Menu $model)
    {
        return false;
    }
}
