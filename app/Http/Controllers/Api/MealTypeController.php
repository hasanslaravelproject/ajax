<?php

namespace App\Http\Controllers\Api;

use App\Models\MealType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MealTypeResource;
use App\Http\Resources\MealTypeCollection;
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
            ->paginate();

        return new MealTypeCollection($mealTypes);
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

        return new MealTypeResource($mealType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MealType $mealType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MealType $mealType)
    {
        $this->authorize('view', $mealType);

        return new MealTypeResource($mealType);
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

        return new MealTypeResource($mealType);
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

        return response()->noContent();
    }
}
