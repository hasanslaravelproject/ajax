<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Company;
use App\Models\FoodMenu;
use App\Models\MealType;
use App\Models\MenuTypes;
use App\Models\measureUnit;
use Illuminate\Http\Request;
use App\Models\FoodMenuFinal;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MenuStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MenuUpdateRequest;
use PhpParser\Node\Stmt\Finally_;

class MenuController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Menu::class);

        $search = $request->get('search', '');

        $menus = Menu::search($search)
            ->latest()
            ->paginate(5);

        return view('app.menus.index', compact('menus', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Menu::class);
        
        $allMenuTypes = MenuTypes::pluck('name', 'id');
        $mealTypes = MealType::pluck('name', 'id');
        $foods = Food::pluck('name', 'id');
        $companies = Company::pluck('name', 'id');
        $measureunit = measureUnit::all();
        $menuid = FoodMenuFinal::orderBy('id', 'desc')->first();
        return view(
            'app.menus.menucreate',
            compact('allMenuTypes', 'mealTypes', 'foods', 'companies', 'measureunit','menuid')
        );
    }

    public function storedata(Request $request){
        $food = $request->food_new;
        $amount = $request->per_person_amount;
        $menuid = $request->menuid;

        //return gettype($amount);
        $food_amount = array_combine($food, $amount);

        foreach($food_amount as $food=>$amount){
            FoodMenuFinal::create([
                'menuid'=>$menuid,
                'food'=> $food,
                'amount'=>$amount
            ]);
        }
        
        return back();
    }

    /**
     * @param \App\Http\Requests\MenuStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $this->authorize('create', Menu::class);
        
       
       
       $input = $request->except('food_new', 'quantity');
       $menu = Menu::create($input);
       $syncData = array();

       $arr1 = $request->food_new;
        $arr2 = $request->quantity;
        
        $com= array_combine($arr1, $arr2);
       
       foreach($com as $i=>$value){
               $syncData[$i] = array('quantity'=>$value);
           }
        
      $menu->foods()->sync($syncData);
       
        
        return redirect()
            ->route('menus.edit', $menu)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Menu $menu)
    {
        $this->authorize('view', $menu);

        return view('app.menus.show', compact('menu'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        $allMenuTypes = MenuTypes::pluck('name', 'id');
        $mealTypes = MealType::pluck('name', 'id');
        $foods = Food::pluck('name', 'id');
        $companies = Company::pluck('name', 'id');

        return view(
            'app.menus.edit',
            compact('menu', 'allMenuTypes', 'mealTypes', 'foods', 'companies')
        );
    }

    /**
     * @param \App\Http\Requests\MenuUpdateRequest $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::delete($menu->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $menu->update($validated);

        return redirect()
            ->route('menus.edit', $menu)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Menu $menu)
    {
        $this->authorize('delete', $menu);

        if ($menu->image) {
            Storage::delete($menu->image);
        }

        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->withSuccess(__('crud.common.removed'));
    }
    
    
    public function insertMenuDetail(Request $request){
        
        //insert data from menu table
        $Menu_insert=new Menu;
        $Menu_insert->name=$request->name;
        $Menu_insert->menu_starts=$request->menu_starts;
        $Menu_insert->validity=$request->validity;
        $Menu_insert->image=null;
        $Menu_insert->food_id=null;
        $Menu_insert->menu_types_id=$request->menu_types_id;
        $Menu_insert->meal_type_id=$request->meal_type_id;
        $Menu_insert->company_id=$request->company_id;
        $Menu_insert->save();
        
        $menu_max_id=Menu::max('id');
        $i=0;
        foreach($request->food as $food_id)
        {
            $quantity= $request->quantity[$i];
            DB::insert('insert into food_menus (food_id, menu_id,food_quantity) values (?, ?,?)', [$food_id, $menu_max_id,"$quantity"]);
           $i++;
     
        }
        
        $response = array(
            'status' => 'success',
            'msg' => "write any msg what you want",
        );
        return response()->json($response); 
    }

    
    public function fetchFoodMenuAjax(Request $request){
        
        
        $menu_id= $request->menu_id;
        $menu_data = DB::table('food_menus')->where('menu_id',$menu_id)->get();
        
     
        $i=0;
        $res="";
        $res.="<table class='table table-bordered table-hover' id='food_menu_table'><thead><tr><th class='text-center'> # </th><th class='text-center'> Food </th><th class='text-center'> Select Qantity </th></tr></thead><tbody>";
        foreach($menu_data as $data_row)
        {
            $food_id=$data_row->food_id;
            $Food_Data=Food::where('id',$food_id)->get();
            
            $res.="<tr id='possition-".$i."'><td>".$i."</td> <td><input type='text' name='food_name[]'  class='form-control' readonly value='".$Food_Data[0]->name."' /></td>
                    <td><input type='number' name='food_quantity[]' placeholder='0' class='form-control food_quantity' min='1' /><input type='hidden' name='food_id[]' class='food_id'  value='".$data_row->food_id."' /></td>
                </tr>";
           $i++;
     
        }
        $res.="</tbody></table>";
        
        $response = array(
            'status' => $food_id,
            'msg' => "write any msg what you want",
        );
        return response()->json($res); 
    }
   
}
