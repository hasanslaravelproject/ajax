<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\FoodMenu;
use App\Models\FoodMenuFinal;

use function PHPSTORM_META\map;

class OrderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Order::class);

        $search = $request->get('search', '');

        $orders = Order::search($search)
            ->latest()
            ->paginate(5);

        return view('app.orders.index', compact('orders', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Order::class);

        $customers = Customer::pluck('name', 'id');
        $menus = Menu::pluck('name', 'id');

        return view('app.orders.create', compact('customers', 'menus'));
    }
    
    /**
     * @param \App\Http\Requests\OrderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validated();

        $order = Order::create($validated);

        return redirect()
            ->route('orders.edit', $order)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        return view('app.orders.show', compact('order'));
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $customers = Customer::pluck('name', 'id');
        $menus = Menu::pluck('name', 'id');

        return view('app.orders.edit', compact('order', 'customers', 'menus'));
    }

    /**
     * @param \App\Http\Requests\OrderUpdateRequest $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validated();
        
        $order->update($validated);

        return redirect()
            ->route('orders.edit', $order)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();

        return redirect()
            ->route('orders.index')
            ->withSuccess(__('crud.common.removed'));
    }


    public function insertOrderDetail(Request $request)
    {


        //insert data from order table
        $Order_insert = new Order;
        $Order_insert->delivery_date = $request->delivery_date;
        $Order_insert->order_quantity = $request->order_quantity;
        $Order_insert->customer_id = $request->customer_id;
        $Order_insert->menu_id = $request->menu_id;
        $Order_insert->save();


        $menu_id = $request->menu_id;
        $order_max_id = Order::max('id');
        $i = 0;
        foreach ($request->food_arr as $food_id) {
            $quantity = $request->quantity_arr[$i];
            DB::insert('insert into order_food (food_id,food_quantity,order_id,menu_id) values (?, ?,?,?)', [$food_id, "$quantity", $order_max_id, $menu_id]);
            $i++;
        }

        $response = array(
            'status' => 'success',
            'msg' => "write any msg what you want",
        );
        return response()->json($response);
    }
    
    public function showOrders()
    {
        $food_details = Food::all();
        // $order_details=Order::Join('customers', function ($join) use ($user_id) {
        //     $join->on('users.id', '=', 'user_favorite_course_videos.user_id')
        //     ->where('users.id', '=', $user_id);
        //   });


        $order_details = DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            //   ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'customers.name')
            ->get();

        $order_food_details = DB::table('order_food')->get();

        return view('app.orders.show-all-orders', ['food_details' => $food_details, 'order_details' => $order_details, 'order_food_details' => $order_food_details]);
    }
    
    public function ShowCompanyOrders(Request $request)
    {
        $Order_Detail = null;
        $Customer_Detail = null;
        if ($request->has('company_id_search')) {
            $Order_Detail = Order::where('customer_id', $request->company_id_search)->get();
            $Customer_Detail = Customer::where('id', $request->company_id_search)->get();
        }
        $Food_Detail = Food::all();
        $order_food_details = DB::table('order_food')->get();
        

        return view('app.orders.show-all-company-orders', ['Order_Details' => $Order_Detail, 'Customer_Details' => $Customer_Detail, 'Food_Details' => $Food_Detail, 'order_food_details' => $order_food_details]);
    }
    function ShowCompanyOrdersall(){
        return view('app.orders.showall');
    }

    public function ShowCompanyOrdersDeliveryDate(Request $request)
    {
        //$Customer_Detail = null;
        //$Order_Detail = null;
        if ($request->has('company_id_search')) {
            $Order_Detail = Order::where('delivery_date', $request->company_id_search)->get();
            $Order_Detail_options = Order::where('delivery_date', $request->company_id_search)->get();
        }
        
       // if (!empty($Order_Detail) > 0) {
         // $Customer_Detail = Customer::where('id', $Order_Detail->customer_id)->first();
        //}
        
        $Food_Detail = Food::all();
        $order_food_details = DB::table('order_food')->get();
        
        return view('app.orders.show-all-company-orders',compact('Order_Detail_options','Order_Detail', 'Food_Detail', 'order_food_details'));
    }
    
    public function showallcustomerorderdetail(Request $request){
        $filterdate = $request->get('date');
        $odersdate = Order::all();
        if(!empty($filterdate)){
            $orders = Order::where('delivery_date', $filterdate)->get();    
        }else{
            $orders = Order::all();
        }
        return view('showallcustomerorder', compact('orders', 'odersdate'));

    }
    
    public function printsticker()
    {
        $customerId = 11; //this is cusid
        $order = Order::where('customer_id', $customerId)->first(); //getting all the order of the cus
        $sticker = 5; //this number will be set by admin 
        
        
        return view('printsticker', compact('order', 'sticker'));
    }
    
    public function companynamewithitem()
    {
        //return $order->menu->foods()->get();
        
        $orders = Order::all();
        return view('showcompanynamewithitem', compact('orders'));
    }
    
    public function quickorder()
    {
        
        $customers = Customer::all();
        $menus = Menu::all();
         $last_order = Order::latest()->first();
         $food = Food::all();
         $finalmenu = FoodMenuFinal::all();
        
        return view('quickorder', compact('finalmenu','food','customers','menus', 'last_order'));
    }
    
    function orderquantity(Request $request){
        
         $quantity = $request->quantity;
         $qd = $quantity / 10;
        
         //div
         if(floor($qd) != $qd){
            $arr = explode('.', number_format($qd, 1));
        }else{
            $arr = explode('.', $qd);
        }
        if ($qd > 1) {
            if(count($arr)>1){
            $add = $arr[0]+1;
            $qd = $arr[1] <= 5 ? '<span class="full">'. $arr[0] . ' Full </span> <br> <span class="half">1 half </span>' : $add . ' Full'; 
            }else{
                $qd= $arr[0] . ' Full';
            }   
        }else{
              $qd= $qd <= 5 ? 'half' : 'full';
        }
         //div
                 
        $food = FoodMenuFinal::pluck('amount');
        
        $test = $food->map(function($f) use ($quantity){
            return ceil($f*$quantity);
        });
        
        $t = [];
         $food = FoodMenuFinal::all();
        
        foreach($food as $f){
            array_push($t, $f->foods->name);
        }
        
        return response()->json(['test'=>$test, 'food'=>$t, 'qd'=>$qd]);
    }
    
    function countquantity(Request $request){
        $array = $request->quantity;

        $arraymap = array_map(function($a){
            return $a/10;
        }, $array);
        
        $half=0;
        $full=[];
        //return count($arr);
        //$qd= /10;
        foreach($arraymap as $ar){
            if(floor($ar) != $ar){
                $arr = explode('.', number_format($ar, 1));
            }else{
                $arr = explode('.', $ar);
            }
            if ($ar > 1) {
                if(count($arr)>1){
                if($arr[1]>5){
                    $add = $arr[0]+1;
                }else{
                    $add = $arr[0];
                }
                $qd = $arr[1] <= 5 ? $half++ : '';
                array_push($full, $add);
            }else{;
                array_push($full, $arr[0]);
            }   
        }else{
            $add= $arr[0]+1;
            $arr[1] <= 5 ? $half++ : array_push($full, $add);
            //$qd= $qd <= 5 ? 'half' : 'full';
        }
    }
    //return $full;
    return array_sum($full) . ' full ' . $half .'half';
         //div
        // return response()->json(['full'=>array_sum($full), 'food'=>$t, 'qd'=>$qd]);
        
    }

    public function saveorder(Request $request)
    {
        $cusid = $request->only('customer_id');
        
        $arr1 = $request->customer_id;
        $arr2 = $request->quantity;
        
       $com= array_combine($arr1, $arr2);
        
        foreach($com as $key=>$val){
            Order::create([
                'delivery_date'=> $request->delivery_date,
                'customer_id'=>$key,
                'order_quantity'=>$val,
                'menu_id'=>$request->menu_id
            ]);
        }

        return 'ok';
    
    }
}
