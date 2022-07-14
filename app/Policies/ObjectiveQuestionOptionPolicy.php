<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ObjectiveQuestionOption;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObjectiveQuestionOptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the objectiveQuestionOption can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestionOption can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestionOption  $model
     * @return mixed
     */
    public function view(User $user, ObjectiveQuestionOption $model)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestionOption can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestionOption can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestionOption  $model
     * @return mixed
     */
    public function update(User $user, ObjectiveQuestionOption $model)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestionOption can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestionOption  $model
     * @return mixed
     */
    public function delete(User $user, ObjectiveQuestionOption $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestionOption  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the objectiveQuestionOption can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestionOption  $model
     * @return mixed
     */
    public function restore(User $user, ObjectiveQuestionOption $model)
    {
        return false;
    }

    /**
     * Determine whether the objectiveQuestionOption can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ObjectiveQuestionOption  $model
     * @return mixed
     */
    public function forceDelete(User $user, ObjectiveQuestionOption $model)
    {
        return false;
    }
}
