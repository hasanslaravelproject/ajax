<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodType;
use Illuminate\Http\Request;
use App\Http\Requests\FoodStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FoodUpdateRequest;

class FoodController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Food::class);

        $search = $request->get('search', '');

        $foods = Food::search($search)
            ->latest()
            ->paginate(5);

        return view('app.foods.index', compact('foods', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Food::class);

        $foodTypes = FoodType::pluck('name', 'id');

        return view('app.foods.create', compact('foodTypes'));
    }

    /**
     * @param \App\Http\Requests\FoodStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodStoreRequest $request)
    {
        $this->authorize('create', Food::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $food = Food::create($validated);
       

        return redirect()
            ->route('foods.edit', $food)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Food $food)
    {
        $this->authorize('view', $food);

        return view('app.foods.show', compact('food'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Food $food)
    {
        $this->authorize('update', $food);

        $foodTypes = FoodType::pluck('name', 'id');

        return view('app.foods.edit', compact('food', 'foodTypes'));
    }

    /**
     * @param \App\Http\Requests\FoodUpdateRequest $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function update(FoodUpdateRequest $request, Food $food)
    {
        $this->authorize('update', $food);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($food->image) {
                Storage::delete($food->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $food->update($validated);

        return redirect()
            ->route('foods.edit', $food)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Food $food)
    {
        $this->authorize('delete', $food);

        if ($food->image) {
            Storage::delete($food->image);
        }

        $food->delete();

        return redirect()
            ->route('foods.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
