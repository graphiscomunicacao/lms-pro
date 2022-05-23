<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ExperienceDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExperienceDetailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the experienceDetail can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the experienceDetail can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExperienceDetail  $model
     * @return mixed
     */
    public function view(User $user, ExperienceDetail $model)
    {
        return true;
    }

    /**
     * Determine whether the experienceDetail can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the experienceDetail can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExperienceDetail  $model
     * @return mixed
     */
    public function update(User $user, ExperienceDetail $model)
    {
        return true;
    }

    /**
     * Determine whether the experienceDetail can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExperienceDetail  $model
     * @return mixed
     */
    public function delete(User $user, ExperienceDetail $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExperienceDetail  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the experienceDetail can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExperienceDetail  $model
     * @return mixed
     */
    public function restore(User $user, ExperienceDetail $model)
    {
        return false;
    }

    /**
     * Determine whether the experienceDetail can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExperienceDetail  $model
     * @return mixed
     */
    public function forceDelete(User $user, ExperienceDetail $model)
    {
        return false;
    }
}
