<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LearningPathGroupResult;
use Illuminate\Auth\Access\HandlesAuthorization;

class LearningPathGroupResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the learningPathGroupResult can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroupResult can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroupResult  $model
     * @return mixed
     */
    public function view(User $user, LearningPathGroupResult $model)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroupResult can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroupResult can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroupResult  $model
     * @return mixed
     */
    public function update(User $user, LearningPathGroupResult $model)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroupResult can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroupResult  $model
     * @return mixed
     */
    public function delete(User $user, LearningPathGroupResult $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroupResult  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroupResult can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroupResult  $model
     * @return mixed
     */
    public function restore(User $user, LearningPathGroupResult $model)
    {
        return false;
    }

    /**
     * Determine whether the learningPathGroupResult can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroupResult  $model
     * @return mixed
     */
    public function forceDelete(User $user, LearningPathGroupResult $model)
    {
        return false;
    }
}
