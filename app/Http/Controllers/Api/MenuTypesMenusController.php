<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuTypes;
use Illuminate\Http\Request;
use App\Http\Resources\MenuResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class MenuTypesMenusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuTypes $menuTypes
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MenuTypes $menuTypes)
    {
        $this->authorize('view', $menuTypes);

        $search = $request->get('search', '');

        $menus = $menuTypes
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuTypes $menuTypes
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MenuTypes $menuTypes)
    {
        $this->authorize('create', Menu::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'menu_starts' => ['nullable', 'date'],
            'validity' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'max:1024'],
            'meal_type_id' => ['required', 'exists:meal_types,id'],
            'food_id' => ['required', 'exists:foods,id'],
            'company_id' => ['required', 'exists:companies,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $menu = $menuTypes->menus()->create($validated);

        return new MenuResource($menu);
    }
}
