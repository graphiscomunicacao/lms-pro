<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Certificate;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the certificate can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the certificate can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Certificate  $model
     * @return mixed
     */
    public function view(User $user, Certificate $model)
    {
        return true;
    }

    /**
     * Determine whether the certificate can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the certificate can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Certificate  $model
     * @return mixed
     */
    public function update(User $user, Certificate $model)
    {
        return true;
    }

    /**
     * Determine whether the certificate can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Certificate  $model
     * @return mixed
     */
    public function delete(User $user, Certificate $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Certificate  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the certificate can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Certificate  $model
     * @return mixed
     */
    public function restore(User $user, Certificate $model)
    {
        return false;
    }

    /**
     * Determine whether the certificate can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Certificate  $model
     * @return mixed
     */
    public function forceDelete(User $user, Certificate $model)
    {
        return false;
    }
}
