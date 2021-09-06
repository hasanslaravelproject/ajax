<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\MealTypeController;
use App\Http\Controllers\MenuTypesController;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/show-order', [OrderController::class, 'showOrders']);

Route::get('/abc', function(){
    return view('index');
});

Route::post('abc',[HomeController::class, 'checkAjaxCall']);
Route::post('xyz',[HomeController::class, 'checkAjaxCall2']);
Route::post('insert-menu',[MenuController::class, 'insertMenuDetail']);
Route::post('insert-order',[OrderController::class,'insertOrderDetail']);

Route::post('fetch-food-menu-ajax',[MenuController::class, 'fetchFoodMenuAjax']);

//from here extra route
Route::get('show-company-orders-all',[OrderController::class, 'ShowCompanyOrdersall']);
Route::get('show-company-orders',[OrderController::class, 'ShowCompanyOrders']);
Route::post('show-company-orders-delivery-date',[OrderController::class, 'ShowCompanyOrdersDeliveryDate'])->name('show-orders');

Route::get('/show-all-company-delivery-detail', [OrderController::class, 'showallcustomerorderdetail'])->name('orderfilter');
Route::get('/printsticker', [OrderController::class, 'printsticker']);

Route::get('/showcompanywithitem', [OrderController::class, 'companynamewithitem']);

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::get('meal-types', [MealTypeController::class, 'index'])->name(
            'meal-types.index'
        );
        Route::post('meal-types', [MealTypeController::class, 'store'])->name(
            'meal-types.store'
        );
        Route::get('meal-types/create', [
            MealTypeController::class,
            'create',
        ])->name('meal-types.create');
        Route::get('meal-types/{mealType}', [
            MealTypeController::class,
            'show',
        ])->name('meal-types.show');
        Route::get('meal-types/{mealType}/edit', [
            MealTypeController::class,
            'edit',
        ])->name('meal-types.edit');
        Route::put('meal-types/{mealType}', [
            MealTypeController::class,
            'update',
        ])->name('meal-types.update');
        Route::delete('meal-types/{mealType}', [
            MealTypeController::class,
            'destroy',
        ])->name('meal-types.destroy');

        Route::get('companies', [CompanyController::class, 'index'])->name(
            'companies.index'
        );
        Route::post('companies', [CompanyController::class, 'store'])->name(
            'companies.store'
        );
        Route::get('companies/create', [
            CompanyController::class,
            'create',
        ])->name('companies.create');
        Route::get('companies/{company}', [
            CompanyController::class,
            'show',
        ])->name('companies.show');
        Route::get('companies/{company}/edit', [
            CompanyController::class,
            'edit',
        ])->name('companies.edit');
        Route::put('companies/{company}', [
            CompanyController::class,
            'update',
        ])->name('companies.update');
        Route::delete('companies/{company}', [
            CompanyController::class,
            'destroy',
        ])->name('companies.destroy');

        Route::get('users', [UserController::class, 'index'])->name(
            'users.index'
        );
        Route::post('users', [UserController::class, 'store'])->name(
            'users.store'
        );
        Route::get('users/create', [UserController::class, 'create'])->name(
            'users.create'
        );
        Route::get('users/{user}', [UserController::class, 'show'])->name(
            'users.show'
        );
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name(
            'users.edit'
        );
        Route::put('users/{user}', [UserController::class, 'update'])->name(
            'users.update'
        );
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name(
            'users.destroy'
        );

        Route::get('all-menu-types', [
            MenuTypesController::class,
            'index',
        ])->name('all-menu-types.index');
        Route::post('all-menu-types', [
            MenuTypesController::class,
            'store',
        ])->name('all-menu-types.store');
        Route::get('all-menu-types/create', [
            MenuTypesController::class,
            'create',
        ])->name('all-menu-types.create');
        Route::get('all-menu-types/{menuTypes}', [
            MenuTypesController::class,
            'show',
        ])->name('all-menu-types.show');
        Route::get('all-menu-types/{menuTypes}/edit', [
            MenuTypesController::class,
            'edit',
        ])->name('all-menu-types.edit');
        Route::put('all-menu-types/{menuTypes}', [
            MenuTypesController::class,
            'update',
        ])->name('all-menu-types.update');
        Route::delete('all-menu-types/{menuTypes}', [
            MenuTypesController::class,
            'destroy',
        ])->name('all-menu-types.destroy');

        Route::get('orders', [OrderController::class, 'index'])->name(
            'orders.index'
        );
        Route::post('orders', [OrderController::class, 'store'])->name(
            'orders.store'
        );
        Route::get('orders/create', [OrderController::class, 'create'])->name(
            'orders.create'
        );
        Route::get('orders/{order}', [OrderController::class, 'show'])->name(
            'orders.show'
        );
        Route::get('orders/{order}/edit', [
            OrderController::class,
            'edit',
        ])->name('orders.edit');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name(
            'orders.update'
        );
        Route::delete('orders/{order}', [
            OrderController::class,
            'destroy',
        ])->name('orders.destroy');

        Route::get('foods', [FoodController::class, 'index'])->name(
            'foods.index'
        );
        Route::post('foods', [FoodController::class, 'store'])->name(
            'foods.store'
        );
        Route::get('foods/create', [FoodController::class, 'create'])->name(
            'foods.create'
        );
        Route::get('foods/{food}', [FoodController::class, 'show'])->name(
            'foods.show'
        );
        Route::get('foods/{food}/edit', [FoodController::class, 'edit'])->name(
            'foods.edit'
        );
        Route::put('foods/{food}', [FoodController::class, 'update'])->name(
            'foods.update'
        );
        Route::delete('foods/{food}', [FoodController::class, 'destroy'])->name(
            'foods.destroy'
        );

        Route::get('menus', [MenuController::class, 'index'])->name(
            'menus.index'
        );
        Route::post('menus', [MenuController::class, 'store'])->name(
            'menus.store'
        );
        Route::get('menus/create', [MenuController::class, 'create'])->name(
            'menus.create'
        );
        Route::get('menus/{menu}', [MenuController::class, 'show'])->name(
            'menus.show'
        );
        Route::get('menus/{menu}/edit', [MenuController::class, 'edit'])->name(
            'menus.edit'
        );
        Route::put('menus/{menu}', [MenuController::class, 'update'])->name(
            'menus.update'
        );
        Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->name(
            'menus.destroy'
        );

        Route::get('food-types', [FoodTypeController::class, 'index'])->name(
            'food-types.index'
        );
        Route::post('food-types', [FoodTypeController::class, 'store'])->name(
            'food-types.store'
        );
        Route::get('food-types/create', [
            FoodTypeController::class,
            'create',
        ])->name('food-types.create');
        Route::get('food-types/{foodType}', [
            FoodTypeController::class,
            'show',
        ])->name('food-types.show');
        Route::get('food-types/{foodType}/edit', [
            FoodTypeController::class,
            'edit',
        ])->name('food-types.edit');
        Route::put('food-types/{foodType}', [
            FoodTypeController::class,
            'update',
        ])->name('food-types.update');
        Route::delete('food-types/{foodType}', [
            FoodTypeController::class,
            'destroy',
        ])->name('food-types.destroy');

        Route::get('customers', [CustomerController::class, 'index'])->name(
            'customers.index'
        );
        Route::post('customers', [CustomerController::class, 'store'])->name(
            'customers.store'
        );
        Route::get('customers/create', [
            CustomerController::class,
            'create',
        ])->name('customers.create');
        Route::get('customers/{customer}', [
            CustomerController::class,
            'show',
        ])->name('customers.show');
        Route::get('customers/{customer}/edit', [
            CustomerController::class,
            'edit',
        ])->name('customers.edit');
        Route::put('customers/{customer}', [
            CustomerController::class,
            'update',
        ])->name('customers.update');
        Route::delete('customers/{customer}', [
            CustomerController::class,
            'destroy',
        ])->name('customers.destroy');

        Route::get('stocks', [StockController::class, 'index'])->name(
            'stocks.index'
        );
        Route::post('stocks', [StockController::class, 'store'])->name(
            'stocks.store'
        );
        Route::get('stocks/create', [StockController::class, 'create'])->name(
            'stocks.create'
        );
        Route::get('stocks/{stock}', [StockController::class, 'show'])->name(
            'stocks.show'
        );
        Route::get('stocks/{stock}/edit', [
            StockController::class,
            'edit',
        ])->name('stocks.edit');
        Route::put('stocks/{stock}', [StockController::class, 'update'])->name(
            'stocks.update'
        );
        Route::delete('stocks/{stock}', [
            StockController::class,
            'destroy',
        ])->name('stocks.destroy');
    });
