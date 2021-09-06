@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('stocks.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.stocks.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.stocks.inputs.name')</h5>
                    <span>{{ $stock->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.stocks.inputs.price')</h5>
                    <span>{{ $stock->price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.stocks.inputs.quantity')</h5>
                    <span>{{ $stock->quantity ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.stocks.inputs.total')</h5>
                    <span>{{ $stock->total ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.stocks.inputs.stock')</h5>
                    <span>{{ $stock->stock ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.stocks.inputs.company_id')</h5>
                    <span>{{ optional($stock->company)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('stocks.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Stock::class)
                <a href="{{ route('stocks.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
