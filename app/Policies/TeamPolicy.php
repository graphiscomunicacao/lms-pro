<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the team can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the team can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Team  $model
     * @return mixed
     */
    public function view(User $user, Team $model)
    {
        return true;
    }

    /**
     * Determine whether the team can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the team can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Team  $model
     * @return mixed
     */
    public function update(User $user, Team $model)
    {
        return true;
    }

    /**
     * Determine whether the team can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Team  $model
     * @return mixed
     */
    public function delete(User $user, Team $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Team  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the team can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Team  $model
     * @return mixed
     */
    public function restore(User $user, Team $model)
    {
        return false;
    }

    /**
     * Determine whether the team can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Team  $model
     * @return mixed
     */
    public function forceDelete(User $user, Team $model)
    {
        return false;
    }
}
