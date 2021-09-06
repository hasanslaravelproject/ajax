<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FoodType;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the foodType can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list foodtypes');
    }

    /**
     * Determine whether the foodType can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FoodType  $model
     * @return mixed
     */
    public function view(User $user, FoodType $model)
    {
        return $user->hasPermissionTo('view foodtypes');
    }

    /**
     * Determine whether the foodType can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create foodtypes');
    }

    /**
     * Determine whether the foodType can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FoodType  $model
     * @return mixed
     */
    public function update(User $user, FoodType $model)
    {
        return $user->hasPermissionTo('update foodtypes');
    }

    /**
     * Determine whether the foodType can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FoodType  $model
     * @return mixed
     */
    public function delete(User $user, FoodType $model)
    {
        return $user->hasPermissionTo('delete foodtypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FoodType  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete foodtypes');
    }

    /**
     * Determine whether the foodType can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FoodType  $model
     * @return mixed
     */
    public function restore(User $user, FoodType $model)
    {
        return false;
    }

    /**
     * Determine whether the foodType can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FoodType  $model
     * @return mixed
     */
    public function forceDelete(User $user, FoodType $model)
    {
        return false;
    }
}
