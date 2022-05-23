<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AchievementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the achievement can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the achievement can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Achievement  $model
     * @return mixed
     */
    public function view(User $user, Achievement $model)
    {
        return true;
    }

    /**
     * Determine whether the achievement can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the achievement can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Achievement  $model
     * @return mixed
     */
    public function update(User $user, Achievement $model)
    {
        return true;
    }

    /**
     * Determine whether the achievement can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Achievement  $model
     * @return mixed
     */
    public function delete(User $user, Achievement $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Achievement  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the achievement can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Achievement  $model
     * @return mixed
     */
    public function restore(User $user, Achievement $model)
    {
        return false;
    }

    /**
     * Determine whether the achievement can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Achievement  $model
     * @return mixed
     */
    public function forceDelete(User $user, Achievement $model)
    {
        return false;
    }
}
