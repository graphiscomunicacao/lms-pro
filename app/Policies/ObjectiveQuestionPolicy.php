<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ObjectiveQuestion;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObjectiveQuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the objectiveQuestion can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestion can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestion  $model
     * @return mixed
     */
    public function view(User $user, ObjectiveQuestion $model)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestion can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestion can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestion  $model
     * @return mixed
     */
    public function update(User $user, ObjectiveQuestion $model)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestion can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestion  $model
     * @return mixed
     */
    public function delete(User $user, ObjectiveQuestion $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestion  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestion can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestion  $model
     * @return mixed
     */
    public function restore(User $user, ObjectiveQuestion $model)
    {
        return false;
    }

    /**
     * Determine whether the objectiveQuestion can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestion  $model
     * @return mixed
     */
    public function forceDelete(User $user, ObjectiveQuestion $model)
    {
        return false;
    }
}
