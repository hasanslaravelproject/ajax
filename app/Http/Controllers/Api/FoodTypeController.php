<?php

namespace App\Http\Controllers\Api;

use App\Models\FoodType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FoodTypeResource;
use App\Http\Resources\FoodTypeCollection;
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
            ->paginate();

        return new FoodTypeCollection($foodTypes);
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

        return new FoodTypeResource($foodType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FoodType $foodType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FoodType $foodType)
    {
        $this->authorize('view', $foodType);

        return new FoodTypeResource($foodType);
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

        return new FoodTypeResource($foodType);
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

        return response()->noContent();
    }
}
