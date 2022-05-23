<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QuizResult;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the quizResult can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the quizResult can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\QuizResult  $model
     * @return mixed
     */
    public function view(User $user, QuizResult $model)
    {
        return true;
    }

    /**
     * Determine whether the quizResult can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the quizResult can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\QuizResult  $model
     * @return mixed
     */
    public function update(User $user, QuizResult $model)
    {
        return true;
    }

    /**
     * Determine whether the quizResult can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\QuizResult  $model
     * @return mixed
     */
    public function delete(User $user, QuizResult $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\QuizResult  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the quizResult can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\QuizResult  $model
     * @return mixed
     */
    public function restore(User $user, QuizResult $model)
    {
        return false;
    }

    /**
     * Determine whether the quizResult can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\QuizResult  $model
     * @return mixed
     */
    public function forceDelete(User $user, QuizResult $model)
    {
        return false;
    }
}
