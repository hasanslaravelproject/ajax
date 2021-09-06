<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuTypesResource;
use App\Http\Resources\MenuTypesCollection;
use App\Http\Requests\MenuTypesStoreRequest;
use App\Http\Requests\MenuTypesUpdateRequest;

class MenuTypesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MenuTypes::class);

        $search = $request->get('search', '');

        $allMenuTypes = MenuTypes::search($search)
            ->latest()
            ->paginate();

        return new MenuTypesCollection($allMenuTypes);
    }

    /**
     * @param \App\Http\Requests\MenuTypesStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuTypesStoreRequest $request)
    {
        $this->authorize('create', MenuTypes::class);

        $validated = $request->validated();

        $menuTypes = MenuTypes::create($validated);

        return new MenuTypesResource($menuTypes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuTypes $menuTypes
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MenuTypes $menuTypes)
    {
        $this->authorize('view', $menuTypes);

        return new MenuTypesResource($menuTypes);
    }

    /**
     * @param \App\Http\Requests\MenuTypesUpdateRequest $request
     * @param \App\Models\MenuTypes $menuTypes
     * @return \Illuminate\Http\Response
     */
    public function update(
        MenuTypesUpdateRequest $request,
        MenuTypes $menuTypes
    ) {
        $this->authorize('update', $menuTypes);

        $validated = $request->validated();

        $menuTypes->update($validated);

        return new MenuTypesResource($menuTypes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuTypes $menuTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MenuTypes $menuTypes)
    {
        $this->authorize('delete', $menuTypes);

        $menuTypes->delete();

        return response()->noContent();
    }
}
