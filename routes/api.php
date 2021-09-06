<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\MealTypeController;
use App\Http\Controllers\Api\FoodTypeController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\MenuTypesController;
use App\Http\Controllers\Api\FoodMenusController;
use App\Http\Controllers\Api\MenuOrdersController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\CompanyUsersController;
use App\Http\Controllers\Api\CompanyMenusController;
use App\Http\Controllers\Api\MealTypeMenusController;
use App\Http\Controllers\Api\CompanyStocksController;
use App\Http\Controllers\Api\FoodTypeFoodsController;
use App\Http\Controllers\Api\MenuTypesMenusController;
use App\Http\Controllers\Api\CustomerOrdersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::get('/meal-types', [MealTypeController::class, 'index'])->name(
            'meal-types.index'
        );
        Route::post('/meal-types', [MealTypeController::class, 'store'])->name(
            'meal-types.store'
        );
        Route::get('/meal-types/{mealType}', [
            MealTypeController::class,
            'show',
        ])->name('meal-types.show');
        Route::put('/meal-types/{mealType}', [
            MealTypeController::class,
            'update',
        ])->name('meal-types.update');
        Route::delete('/meal-types/{mealType}', [
            MealTypeController::class,
            'destroy',
        ])->name('meal-types.destroy');

        // MealType Menus
        Route::get('/meal-types/{mealType}/menus', [
            MealTypeMenusController::class,
            'index',
        ])->name('meal-types.menus.index');
        Route::post('/meal-types/{mealType}/menus', [
            MealTypeMenusController::class,
            'store',
        ])->name('meal-types.menus.store');

        Route::get('/companies', [CompanyController::class, 'index'])->name(
            'companies.index'
        );
        Route::post('/companies', [CompanyController::class, 'store'])->name(
            'companies.store'
        );
        Route::get('/companies/{company}', [
            CompanyController::class,
            'show',
        ])->name('companies.show');
        Route::put('/companies/{company}', [
            CompanyController::class,
            'update',
        ])->name('companies.update');
        Route::delete('/companies/{company}', [
            CompanyController::class,
            'destroy',
        ])->name('companies.destroy');

        // Company Users
        Route::get('/companies/{company}/users', [
            CompanyUsersController::class,
            'index',
        ])->name('companies.users.index');
        Route::post('/companies/{company}/users', [
            CompanyUsersController::class,
            'store',
        ])->name('companies.users.store');

        // Company Menus
        Route::get('/companies/{company}/menus', [
            CompanyMenusController::class,
            'index',
        ])->name('companies.menus.index');
        Route::post('/companies/{company}/menus', [
            CompanyMenusController::class,
            'store',
        ])->name('companies.menus.store');

        // Company Stocks
        Route::get('/companies/{company}/stocks', [
            CompanyStocksController::class,
            'index',
        ])->name('companies.stocks.index');
        Route::post('/companies/{company}/stocks', [
            CompanyStocksController::class,
            'store',
        ])->name('companies.stocks.store');

        Route::get('/users', [UserController::class, 'index'])->name(
            'users.index'
        );
        Route::post('/users', [UserController::class, 'store'])->name(
            'users.store'
        );
        Route::get('/users/{user}', [UserController::class, 'show'])->name(
            'users.show'
        );
        Route::put('/users/{user}', [UserController::class, 'update'])->name(
            'users.update'
        );
        Route::delete('/users/{user}', [
            UserController::class,
            'destroy',
        ])->name('users.destroy');

        Route::get('/all-menu-types', [
            MenuTypesController::class,
            'index',
        ])->name('all-menu-types.index');
        Route::post('/all-menu-types', [
            MenuTypesController::class,
            'store',
        ])->name('all-menu-types.store');
        Route::get('/all-menu-types/{menuTypes}', [
            MenuTypesController::class,
            'show',
        ])->name('all-menu-types.show');
        Route::put('/all-menu-types/{menuTypes}', [
            MenuTypesController::class,
            'update',
        ])->name('all-menu-types.update');
        Route::delete('/all-menu-types/{menuTypes}', [
            MenuTypesController::class,
            'destroy',
        ])->name('all-menu-types.destroy');

        // MenuTypes Menus
        Route::get('/all-menu-types/{menuTypes}/menus', [
            MenuTypesMenusController::class,
            'index',
        ])->name('all-menu-types.menus.index');
        Route::post('/all-menu-types/{menuTypes}/menus', [
            MenuTypesMenusController::class,
            'store',
        ])->name('all-menu-types.menus.store');

        Route::get('/orders', [OrderController::class, 'index'])->name(
            'orders.index'
        );
        Route::post('/orders', [OrderController::class, 'store'])->name(
            'orders.store'
        );
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name(
            'orders.show'
        );
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name(
            'orders.update'
        );
        Route::delete('/orders/{order}', [
            OrderController::class,
            'destroy',
        ])->name('orders.destroy');

        Route::get('/foods', [FoodController::class, 'index'])->name(
            'foods.index'
        );
        Route::post('/foods', [FoodController::class, 'store'])->name(
            'foods.store'
        );
        Route::get('/foods/{food}', [FoodController::class, 'show'])->name(
            'foods.show'
        );
        Route::put('/foods/{food}', [FoodController::class, 'update'])->name(
            'foods.update'
        );
        Route::delete('/foods/{food}', [
            FoodController::class,
            'destroy',
        ])->name('foods.destroy');

        // Food Menus
        Route::get('/foods/{food}/menus', [
            FoodMenusController::class,
            'index',
        ])->name('foods.menus.index');
        Route::post('/foods/{food}/menus', [
            FoodMenusController::class,
            'store',
        ])->name('foods.menus.store');

        Route::get('/menus', [MenuController::class, 'index'])->name(
            'menus.index'
        );
        Route::post('/menus', [MenuController::class, 'store'])->name(
            'menus.store'
        );
        Route::get('/menus/{menu}', [MenuController::class, 'show'])->name(
            'menus.show'
        );
        Route::put('/menus/{menu}', [MenuController::class, 'update'])->name(
            'menus.update'
        );
        Route::delete('/menus/{menu}', [
            MenuController::class,
            'destroy',
        ])->name('menus.destroy');

        // Menu Orders
        Route::get('/menus/{menu}/orders', [
            MenuOrdersController::class,
            'index',
        ])->name('menus.orders.index');
        Route::post('/menus/{menu}/orders', [
            MenuOrdersController::class,
            'store',
        ])->name('menus.orders.store');

        Route::get('/food-types', [FoodTypeController::class, 'index'])->name(
            'food-types.index'
        );
        Route::post('/food-types', [FoodTypeController::class, 'store'])->name(
            'food-types.store'
        );
        Route::get('/food-types/{foodType}', [
            FoodTypeController::class,
            'show',
        ])->name('food-types.show');
        Route::put('/food-types/{foodType}', [
            FoodTypeController::class,
            'update',
        ])->name('food-types.update');
        Route::delete('/food-types/{foodType}', [
            FoodTypeController::class,
            'destroy',
        ])->name('food-types.destroy');

        // FoodType Foods
        Route::get('/food-types/{foodType}/foods', [
            FoodTypeFoodsController::class,
            'index',
        ])->name('food-types.foods.index');
        Route::post('/food-types/{foodType}/foods', [
            FoodTypeFoodsController::class,
            'store',
        ])->name('food-types.foods.store');

        Route::get('/customers', [CustomerController::class, 'index'])->name(
            'customers.index'
        );
        Route::post('/customers', [CustomerController::class, 'store'])->name(
            'customers.store'
        );
        Route::get('/customers/{customer}', [
            CustomerController::class,
            'show',
        ])->name('customers.show');
        Route::put('/customers/{customer}', [
            CustomerController::class,
            'update',
        ])->name('customers.update');
        Route::delete('/customers/{customer}', [
            CustomerController::class,
            'destroy',
        ])->name('customers.destroy');

        // Customer Orders
        Route::get('/customers/{customer}/orders', [
            CustomerOrdersController::class,
            'index',
        ])->name('customers.orders.index');
        Route::post('/customers/{customer}/orders', [
            CustomerOrdersController::class,
            'store',
        ])->name('customers.orders.store');

        Route::get('/stocks', [StockController::class, 'index'])->name(
            'stocks.index'
        );
        Route::post('/stocks', [StockController::class, 'store'])->name(
            'stocks.store'
        );
        Route::get('/stocks/{stock}', [StockController::class, 'show'])->name(
            'stocks.show'
        );
        Route::put('/stocks/{stock}', [StockController::class, 'update'])->name(
            'stocks.update'
        );
        Route::delete('/stocks/{stock}', [
            StockController::class,
            'destroy',
        ])->name('stocks.destroy');
    });
