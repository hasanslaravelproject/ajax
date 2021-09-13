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

    public function menu()
    {
        return $this->belongsToMany(Menu::class)->withPivot('quantity');
    }
    
    public function ordercount()
    {
        //return $this->id;
        $menu = $this->menu()->first();
        $oq = Order::where('menu_id', $menu->id)->get();

        $arr =[];

        foreach($oq as $q){
            array_push($arr, $q->order_quantity);
        }
        
        $divar = [];
        foreach($arr as $ar){
            $num = $ar/ $this->div_no;
            $snum ='';
            if(floor($num) != $num){
                $arr = explode('.', number_format($num, 1));
                if($arr[1] > 5){
                    $snum = round($num);
                }else{
                    $snum = $num;
                }
            }else{
                $snum= $num;
            }
            array_push($divar, $snum);
        }
        //return implode($divar);
        $sumno = array_sum($divar);

        return $this->showquantiy($sumno);  
        return $oq / $this->div_no;
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
}