<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodMenuFinal extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = "finalmenu";
    
    public $timestamps = false;


    public function foods(){
      return $this->belongsTo(Food::class, 'food', 'id');
    }


}
