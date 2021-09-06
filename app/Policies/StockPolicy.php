<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Stock;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the stock can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list stocks');
    }

    /**
     * Determine whether the stock can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Stock  $model
     * @return mixed
     */
    public function view(User $user, Stock $model)
    {
        return $user->hasPermissionTo('view stocks');
    }

    /**
     * Determine whether the stock can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create stocks');
    }

    /**
     * Determine whether the stock can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Stock  $model
     * @return mixed
     */
    public function update(User $user, Stock $model)
    {
        return $user->hasPermissionTo('update stocks');
    }

    /**
     * Determine whether the stock can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Stock  $model
     * @return mixed
     */
    public function delete(User $user, Stock $model)
    {
        return $user->hasPermissionTo('delete stocks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Stock  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete stocks');
    }

    /**
     * Determine whether the stock can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Stock  $model
     * @return mixed
     */
    public function restore(User $user, Stock $model)
    {
        return false;
    }

    /**
     * Determine whether the stock can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Stock  $model
     * @return mixed
     */
    public function forceDelete(User $user, Stock $model)
    {
        return false;
    }
}
