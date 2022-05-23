<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the quiz can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the quiz can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quiz  $model
     * @return mixed
     */
    public function view(User $user, Quiz $model)
    {
        return true;
    }

    /**
     * Determine whether the quiz can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the quiz can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quiz  $model
     * @return mixed
     */
    public function update(User $user, Quiz $model)
    {
        return true;
    }

    /**
     * Determine whether the quiz can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quiz  $model
     * @return mixed
     */
    public function delete(User $user, Quiz $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quiz  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the quiz can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quiz  $model
     * @return mixed
     */
    public function restore(User $user, Quiz $model)
    {
        return false;
    }

    /**
     * Determine whether the quiz can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quiz  $model
     * @return mixed
     */
    public function forceDelete(User $user, Quiz $model)
    {
        return false;
    }
}
