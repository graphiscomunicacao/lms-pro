<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LearningPathGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class LearningPathGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the learningPathGroup can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroup can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroup  $model
     * @return mixed
     */
    public function view(User $user, LearningPathGroup $model)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroup can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroup can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroup  $model
     * @return mixed
     */
    public function update(User $user, LearningPathGroup $model)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroup can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroup  $model
     * @return mixed
     */
    public function delete(User $user, LearningPathGroup $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroup  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningPathGroup can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroup  $model
     * @return mixed
     */
    public function restore(User $user, LearningPathGroup $model)
    {
        return false;
    }

    /**
     * Determine whether the learningPathGroup can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPathGroup  $model
     * @return mixed
     */
    public function forceDelete(User $user, LearningPathGroup $model)
    {
        return false;
    }
}
