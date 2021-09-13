<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StockStoreRequest;
use App\Http\Requests\StockUpdateRequest;

class StockController extends Controller
{
    function guestdiv(){
        $foods = Food::all();
        $orders = Order::all();

        return view('guestdiv', compact('foods', 'orders'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Stock::class);

        $search = $request->get('search', '');

        $stocks = Stock::search($search)
            ->latest()
            ->paginate(5);

        return view('app.stocks.index', compact('stocks', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       //return Menu::find(41)->orders()->get();
        $this->authorize('create', Stock::class);
        if($request->get('menu_id')){
           $orders = Menu::find($request->get('menu_id'))->orders()->orderBy('delivery_date', 'asc')->get();
        }else{
            $orders = Order::all();
        }
        $foods = Food::all();
        
        $customer = Customer::all();
        $companies = Company::pluck('name', 'id');
        $menus = Menu::all();
        
        return view('app.stocks.create', compact('foods','orders','menus','companies', 'customer'));
    }
    
    /**
     * @param \App\Http\Requests\StockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockStoreRequest $request)
    {
        $this->authorize('create', Stock::class);
        
        $validated = $request->validated();
        
        $stock = Stock::create($validated);

        return redirect()
            ->route('stocks.edit', $stock)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Stock $stock)
    {
        $this->authorize('view', $stock);

        return view('app.stocks.show', compact('stock'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Stock $stock)
    {
        $this->authorize('update', $stock);

        $companies = Company::pluck('name', 'id');

        return view('app.stocks.edit', compact('stock', 'companies'));
    }

    /**
     * @param \App\Http\Requests\StockUpdateRequest $request
     * @param \App\Models\Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function update(StockUpdateRequest $request, Stock $stock)
    {
        $this->authorize('update', $stock);

        $validated = $request->validated();

        $stock->update($validated);

        return redirect()
            ->route('stocks.edit', $stock)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Stock $stock)
    {
        $this->authorize('delete', $stock);

        $stock->delete();

        return redirect()
            ->route('stocks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
