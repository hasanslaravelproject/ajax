<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model
{
    use HasFactory;
    use Searchable;
    public $table="foods";
    
    protected $guarded = [];

    protected $searchableFields = ['*'];

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}