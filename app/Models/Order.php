<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
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
        $arr = explode('.', $array);
        if ($array > 1) {
            if(count($arr)>1){
                return $arr[1] < 5 ? $arr[0] . ' & half' : '';
            }else{
                return $arr[0];
            }   
        }else{
            return $array < 5 ? 'half' : 'full';
        }
    

    }
}
