<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ObjectiveAnswer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObjectiveAnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the objectiveAnswer can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the objectiveAnswer can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveAnswer  $model
     * @return mixed
     */
    public function view(User $user, ObjectiveAnswer $model)
    {
        return true;
    }

    /**
     * Determine whether the objectiveAnswer can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the objectiveAnswer can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveAnswer  $model
     * @return mixed
     */
    public function update(User $user, ObjectiveAnswer $model)
    {
        return true;
    }

    /**
     * Determine whether the objectiveAnswer can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveAnswer  $model
     * @return mixed
     */
    public function delete(User $user, ObjectiveAnswer $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveAnswer  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the objectiveAnswer can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveAnswer  $model
     * @return mixed
     */
    public function restore(User $user, ObjectiveAnswer $model)
    {
        return false;
    }

    /**
     * Determine whether the objectiveAnswer can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveAnswer  $model
     * @return mixed
     */
    public function forceDelete(User $user, ObjectiveAnswer $model)
    {
        return false;
    }
}
