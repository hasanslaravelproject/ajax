<?php

namespace App\Http\Controllers\Api;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Http\Resources\MenuResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class FoodMenusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Food $food)
    {
        $this->authorize('view', $food);

        $search = $request->get('search', '');

        $menus = $food
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Food $food)
    {
        $this->authorize('create', Menu::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'menu_starts' => ['nullable', 'date'],
            'validity' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'max:1024'],
            'menu_types_id' => ['required', 'exists:menu_types,id'],
            'meal_type_id' => ['required', 'exists:meal_types,id'],
            'company_id' => ['required', 'exists:companies,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $menu = $food->menus()->create($validated);

        return new MenuResource($menu);
    }
}
