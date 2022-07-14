<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the job can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the job can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Job  $model
     * @return mixed
     */
    public function view(User $user, Job $model)
    {
        return true;
    }

    /**
     * Determine whether the job can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the job can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Job  $model
     * @return mixed
     */
    public function update(User $user, Job $model)
    {
        return true;
    }

    /**
     * Determine whether the job can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Job  $model
     * @return mixed
     */
    public function delete(User $user, Job $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Job  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the job can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Job  $model
     * @return mixed
     */
    public function restore(User $user, Job $model)
    {
        return false;
    }

    /**
     * Determine whether the job can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Job  $model
     * @return mixed
     */
    public function forceDelete(User $user, Job $model)
    {
        return false;
    }
}
