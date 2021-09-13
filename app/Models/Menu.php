<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $casts = [
        'menu_starts' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function menuTypes()
    {
        return $this->belongsTo(MenuTypes::class);
    }
    
    public function mealType()
    {
        return $this->belongsTo(MealType::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_menu', 'menu_id', 'food_id')->withPivot('quantity');
    }
   
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
