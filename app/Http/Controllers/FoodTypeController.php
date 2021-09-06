<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use Illuminate\Http\Request;
use App\Http\Requests\FoodTypeStoreRequest;
use App\Http\Requests\FoodTypeUpdateRequest;

class FoodTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FoodType::class);

        $search = $request->get('search', '');

        $foodTypes = FoodType::search($search)
            ->latest()
            ->paginate(5);

        return view('app.food_types.index', compact('foodTypes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', FoodType::class);

        return view('app.food_types.create');
    }

    /**
     * @param \App\Http\Requests\FoodTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodTypeStoreRequest $request)
    {
        $this->authorize('create', FoodType::class);

        $validated = $request->validated();

        $foodType = FoodType::create($validated);

        return redirect()
            ->route('food-types.edit', $foodType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FoodType $foodType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FoodType $foodType)
    {
        $this->authorize('view', $foodType);

        return view('app.food_types.show', compact('foodType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FoodType $foodType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FoodType $foodType)
    {
        $this->authorize('update', $foodType);

        return view('app.food_types.edit', compact('foodType'));
    }

    /**
     * @param \App\Http\Requests\FoodTypeUpdateRequest $request
     * @param \App\Models\FoodType $foodType
     * @return \Illuminate\Http\Response
     */
    public function update(FoodTypeUpdateRequest $request, FoodType $foodType)
    {
        $this->authorize('update', $foodType);

        $validated = $request->validated();

        $foodType->update($validated);

        return redirect()
            ->route('food-types.edit', $foodType)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FoodType $foodType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FoodType $foodType)
    {
        $this->authorize('delete', $foodType);

        $foodType->delete();

        return redirect()
            ->route('food-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
