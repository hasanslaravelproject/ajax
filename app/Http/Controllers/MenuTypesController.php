<?php

namespace App\Http\Controllers;

use App\Models\MenuTypes;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view(
            'app.all_menu_types.index',
            compact('allMenuTypes', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', MenuTypes::class);

        return view('app.all_menu_types.create');
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

        return redirect()
            ->route('all-menu-types.edit', $menuTypes)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuTypes $menuTypes
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MenuTypes $menuTypes)
    {
        $this->authorize('view', $menuTypes);

        return view('app.all_menu_types.show', compact('menuTypes'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuTypes $menuTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MenuTypes $menuTypes)
    {
        $this->authorize('update', $menuTypes);

        return view('app.all_menu_types.edit', compact('menuTypes'));
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

        return redirect()
            ->route('all-menu-types.edit', $menuTypes)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('all-menu-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
