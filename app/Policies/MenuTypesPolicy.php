<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MenuTypes;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuTypesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the menuTypes can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list allmenutypes');
    }

    /**
     * Determine whether the menuTypes can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuTypes  $model
     * @return mixed
     */
    public function view(User $user, MenuTypes $model)
    {
        return $user->hasPermissionTo('view allmenutypes');
    }

    /**
     * Determine whether the menuTypes can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create allmenutypes');
    }

    /**
     * Determine whether the menuTypes can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuTypes  $model
     * @return mixed
     */
    public function update(User $user, MenuTypes $model)
    {
        return $user->hasPermissionTo('update allmenutypes');
    }

    /**
     * Determine whether the menuTypes can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuTypes  $model
     * @return mixed
     */
    public function delete(User $user, MenuTypes $model)
    {
        return $user->hasPermissionTo('delete allmenutypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuTypes  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete allmenutypes');
    }

    /**
     * Determine whether the menuTypes can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuTypes  $model
     * @return mixed
     */
    public function restore(User $user, MenuTypes $model)
    {
        return false;
    }

    /**
     * Determine whether the menuTypes can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuTypes  $model
     * @return mixed
     */
    public function forceDelete(User $user, MenuTypes $model)
    {
        return false;
    }
}
