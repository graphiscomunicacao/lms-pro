<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LearningArtifact;
use Illuminate\Auth\Access\HandlesAuthorization;

class LearningArtifactPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the learningArtifact can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningArtifact can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningArtifact  $model
     * @return mixed
     */
    public function view(User $user, LearningArtifact $model)
    {
        return true;
    }

    /**
     * Determine whether the learningArtifact can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningArtifact can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningArtifact  $model
     * @return mixed
     */
    public function update(User $user, LearningArtifact $model)
    {
        return true;
    }

    /**
     * Determine whether the learningArtifact can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningArtifact  $model
     * @return mixed
     */
    public function delete(User $user, LearningArtifact $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningArtifact  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the learningArtifact can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningArtifact  $model
     * @return mixed
     */
    public function restore(User $user, LearningArtifact $model)
    {
        return false;
    }

    /**
     * Determine whether the learningArtifact can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LearningArtifact  $model
     * @return mixed
     */
    public function forceDelete(User $user, LearningArtifact $model)
    {
        return false;
    }
}
