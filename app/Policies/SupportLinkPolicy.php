<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SupportLink;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupportLinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the supportLink can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the supportLink can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupportLink  $model
     * @return mixed
     */
    public function view(User $user, SupportLink $model)
    {
        return true;
    }

    /**
     * Determine whether the supportLink can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the supportLink can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupportLink  $model
     * @return mixed
     */
    public function update(User $user, SupportLink $model)
    {
        return true;
    }

    /**
     * Determine whether the supportLink can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupportLink  $model
     * @return mixed
     */
    public function delete(User $user, SupportLink $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupportLink  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the supportLink can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupportLink  $model
     * @return mixed
     */
    public function restore(User $user, SupportLink $model)
    {
        return false;
    }

    /**
     * Determine whether the supportLink can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupportLink  $model
     * @return mixed
     */
    public function forceDelete(User $user, SupportLink $model)
    {
        return false;
    }
}
