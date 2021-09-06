<div>
    <div class="mb-4">
        @can('create', App\Models\Stock::class)
        <button class="btn btn-primary" wire:click="newStock">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Stock::class)
        <button
            class="btn btn-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="icon ion-md-trash"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal id="company-stocks-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text
                            name="stock.name"
                            label="Name"
                            wire:model="stock.name"
                            maxlength="255"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number
                            name="stock.price"
                            label="Price"
                            wire:model="stock.price"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number
                            name="stock.quantity"
                            label="Quantity"
                            wire:model="stock.quantity"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number
                            name="stock.total"
                            label="Total"
                            wire:model="stock.total"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number
                            name="stock.stock"
                            label="Stock"
                            wire:model="stock.stock"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>
                </div>
            </div>

            @if($editing) @endif

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light float-left"
                    wire:click="$toggle('showingModal')"
                >
                    <i class="icon ion-md-close"></i>
                    @lang('crud.common.cancel')
                </button>

                <button type="button" class="btn btn-primary" wire:click="save">
                    <i class="icon ion-md-save"></i>
                    @lang('crud.common.save')
                </button>
            </div>
        </div>
    </x-modal>

    <div class="table-responsive">
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th>
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="text-left">
                        @lang('crud.company_stocks.inputs.name')
                    </th>
                    <th class="text-right">
                        @lang('crud.company_stocks.inputs.price')
                    </th>
                    <th class="text-right">
                        @lang('crud.company_stocks.inputs.quantity')
                    </th>
                    <th class="text-right">
                        @lang('crud.company_stocks.inputs.total')
                    </th>
                    <th class="text-right">
                        @lang('crud.company_stocks.inputs.stock')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($stocks as $stock)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $stock->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">{{ $stock->name ?? '-' }}</td>
                    <td class="text-right">{{ $stock->price ?? '-' }}</td>
                    <td class="text-right">{{ $stock->quantity ?? '-' }}</td>
                    <td class="text-right">{{ $stock->total ?? '-' }}</td>
                    <td class="text-right">{{ $stock->stock ?? '-' }}</td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $stock)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editStock({{ $stock->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">{{ $stocks->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
