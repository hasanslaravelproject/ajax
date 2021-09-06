<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\MenuResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class CompanyMenusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        $search = $request->get('search', '');

        $menus = $company
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', Menu::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'menu_starts' => ['nullable', 'date'],
            'validity' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'max:1024'],
            'menu_types_id' => ['required', 'exists:menu_types,id'],
            'meal_type_id' => ['required', 'exists:meal_types,id'],
            'food_id' => ['required', 'exists:foods,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $menu = $company->menus()->create($validated);

        return new MenuResource($menu);
    }
}
