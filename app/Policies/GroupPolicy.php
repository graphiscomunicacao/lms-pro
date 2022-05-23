<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the group can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the group can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Group  $model
     * @return mixed
     */
    public function view(User $user, Group $model)
    {
        return true;
    }

    /**
     * Determine whether the group can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the group can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Group  $model
     * @return mixed
     */
    public function update(User $user, Group $model)
    {
        return true;
    }

    /**
     * Determine whether the group can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Group  $model
     * @return mixed
     */
    public function delete(User $user, Group $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Group  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the group can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Group  $model
     * @return mixed
     */
    public function restore(User $user, Group $model)
    {
        return false;
    }

    /**
     * Determine whether the group can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Group  $model
     * @return mixed
     */
    public function forceDelete(User $user, Group $model)
    {
        return false;
    }
}
