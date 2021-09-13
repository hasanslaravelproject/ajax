<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];
    
    protected $casts = [
        'delivery_date' => 'datetime',
    ];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    
    public function showquantiy($array)
    {
        //return number_format($array, 1);
        if(floor($array) != $array){
            $arr = explode('.', number_format($array, 1));
        }else{
            $arr = explode('.', $array);
        }
        if ($array > 1) {
            if(count($arr)>1){
            $add = $arr[0]+1;
            return $arr[1] <= 5 ? $arr[0] . ' Full & half' : $add . ' Full'; 
            }else{
                return $arr[0] . ' Full';
            }   
        }else{
            return $array <= 5 ? 'half' : 'full';
        }
    
    
    }
    
    function division($quantity){
        $menu = DB::table('menus')->where('id', $this->menu_id)->first();
        //$company = DB::table('companies')->where('id', $menu->company_id)->first();
        $food = DB::table('foods')->where('id', $menu->food_id)->first();
        if($food->div_no!= 0){
            return $quantity/$food->div_no;
        }
        
        return $quantity;
    
    }
}
