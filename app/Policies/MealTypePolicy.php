<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MealType;
use Illuminate\Auth\Access\HandlesAuthorization;

class MealTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the mealType can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list mealtypes');
    }

    /**
     * Determine whether the mealType can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MealType  $model
     * @return mixed
     */
    public function view(User $user, MealType $model)
    {
        return $user->hasPermissionTo('view mealtypes');
    }

    /**
     * Determine whether the mealType can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create mealtypes');
    }

    /**
     * Determine whether the mealType can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MealType  $model
     * @return mixed
     */
    public function update(User $user, MealType $model)
    {
        return $user->hasPermissionTo('update mealtypes');
    }

    /**
     * Determine whether the mealType can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MealType  $model
     * @return mixed
     */
    public function delete(User $user, MealType $model)
    {
        return $user->hasPermissionTo('delete mealtypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MealType  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete mealtypes');
    }

    /**
     * Determine whether the mealType can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MealType  $model
     * @return mixed
     */
    public function restore(User $user, MealType $model)
    {
        return false;
    }

    /**
     * Determine whether the mealType can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MealType  $model
     * @return mixed
     */
    public function forceDelete(User $user, MealType $model)
    {
        return false;
    }
}
