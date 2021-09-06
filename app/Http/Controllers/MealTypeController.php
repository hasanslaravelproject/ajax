<?php

namespace App\Http\Controllers;

use App\Models\MealType;
use Illuminate\Http\Request;
use App\Http\Requests\MealTypeStoreRequest;
use App\Http\Requests\MealTypeUpdateRequest;

class MealTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MealType::class);

        $search = $request->get('search', '');

        $mealTypes = MealType::search($search)
            ->latest()
            ->paginate(5);

        return view('app.meal_types.index', compact('mealTypes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', MealType::class);

        return view('app.meal_types.create');
    }

    /**
     * @param \App\Http\Requests\MealTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MealTypeStoreRequest $request)
    {
        $this->authorize('create', MealType::class);

        $validated = $request->validated();

        $mealType = MealType::create($validated);

        return redirect()
            ->route('meal-types.edit', $mealType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MealType $mealType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MealType $mealType)
    {
        $this->authorize('view', $mealType);

        return view('app.meal_types.show', compact('mealType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MealType $mealType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MealType $mealType)
    {
        $this->authorize('update', $mealType);

        return view('app.meal_types.edit', compact('mealType'));
    }

    /**
     * @param \App\Http\Requests\MealTypeUpdateRequest $request
     * @param \App\Models\MealType $mealType
     * @return \Illuminate\Http\Response
     */
    public function update(MealTypeUpdateRequest $request, MealType $mealType)
    {
        $this->authorize('update', $mealType);

        $validated = $request->validated();

        $mealType->update($validated);

        return redirect()
            ->route('meal-types.edit', $mealType)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MealType $mealType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MealType $mealType)
    {
        $this->authorize('delete', $mealType);

        $mealType->delete();

        return redirect()
            ->route('meal-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
