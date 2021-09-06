<?php

namespace App\Http\Controllers\Api;

use App\Models\MealType;
use Illuminate\Http\Request;
use App\Http\Resources\MenuResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class MealTypeMenusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MealType $mealType
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MealType $mealType)
    {
        $this->authorize('view', $mealType);

        $search = $request->get('search', '');

        $menus = $mealType
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MealType $mealType
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MealType $mealType)
    {
        $this->authorize('create', Menu::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'menu_starts' => ['nullable', 'date'],
            'validity' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'max:1024'],
            'menu_types_id' => ['required', 'exists:menu_types,id'],
            'food_id' => ['required', 'exists:foods,id'],
            'company_id' => ['required', 'exists:companies,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $menu = $mealType->menus()->create($validated);

        return new MenuResource($menu);
    }
}
