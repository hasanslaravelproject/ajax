<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Stock;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders =Order::all();
        $menus =Menu::all();
       
        return view('home', compact('orders', 'menus'));
    }
    
    public function checkAjaxCall(Request $request){
        
    
        //insert data from stock table
         $Stock_insert=new Stock;
         $Stock_insert->name=$request->name;
         $Stock_insert->price=$request->price;
         $Stock_insert->quantity=$request->quantity;
         $Stock_insert->total=$request->total;
         $Stock_insert->stock=$request->stock;
         $Stock_insert->company_id=$request->company_id;
         $Stock_insert->save();

        $response = array(
            'status' => 'success',
            'msg' => "write any msg what you want",
        );
        return response()->json($response); 
    }
    
    public function checkAjaxCall2(Request $request){
        
        //insert data from stock table
        $i=0;
        foreach($request->name as $product_name)
        {
         $grand_total=0;
         $price=$request->price[$i];
         $quantiy=$request->quantity[$i];
         $grand_total=$price*$quantiy;
        
         $Stock_insert=new Stock;
         $Stock_insert->name=$request->name[$i];
         $Stock_insert->price=$request->price[$i];
         $Stock_insert->quantity=$request->quantity[$i];
         $Stock_insert->total=$grand_total;
         $Stock_insert->stock=$request->stock[$i];
         $Stock_insert->company_id=$request->company_id;
         $Stock_insert->save();
         $i++; 
        }
        
        $response = array(
            'status' => 'success',
            'msg' => "write any msg what you want",
        );
        return response()->json($response); 
    }
   
    
}
