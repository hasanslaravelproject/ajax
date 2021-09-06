<?php

namespace App\Http\Controllers\Api;

use App\Models\FoodType;
use Illuminate\Http\Request;
use App\Http\Resources\FoodResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FoodCollection;

class FoodTypeFoodsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FoodType $foodType
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FoodType $foodType)
    {
        $this->authorize('view', $foodType);

        $search = $request->get('search', '');

        $foods = $foodType
            ->foods()
            ->search($search)
            ->latest()
            ->paginate();

        return new FoodCollection($foods);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FoodType $foodType
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FoodType $foodType)
    {
        $this->authorize('create', Food::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'image' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $food = $foodType->foods()->create($validated);

        return new FoodResource($food);
    }
}
