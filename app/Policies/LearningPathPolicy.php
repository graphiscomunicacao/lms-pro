<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LearningPath;
use Illuminate\Auth\Access\HandlesAuthorization;

class LearningPathPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the learningPath can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningPath can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPath  $model
     * @return mixed
     */
    public function view(User $user, LearningPath $model)
    {
        return true;
    }

    /**
     * Determine whether the learningPath can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningPath can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPath  $model
     * @return mixed
     */
    public function update(User $user, LearningPath $model)
    {
        return true;
    }

    /**
     * Determine whether the learningPath can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPath  $model
     * @return mixed
     */
    public function delete(User $user, LearningPath $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPath  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningPath can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPath  $model
     * @return mixed
     */
    public function restore(User $user, LearningPath $model)
    {
        return false;
    }

    /**
     * Determine whether the learningPath can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningPath  $model
     * @return mixed
     */
    public function forceDelete(User $user, LearningPath $model)
    {
        return false;
    }
}
