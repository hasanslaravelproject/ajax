@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
        <table class="table table-bordered">
        <thead>
                    <tr>
                    <th scope="col">Customer Name</th>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                    </tr>
                </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <th scope="row">{{$order->customer->name}}</th>
                    <td>{{$order->menu->name}}</td>
                    <td>
                    @foreach ($order->menu->foods()->get() as $food)
                    name : {{$food->name}}
                        @if ($order->menu->menuTypes != 'buffet')
                        <td>quantity required: {{$order->showquantiy($order->order_quantity/$food->div_no)}}</td>
                        @else
                        <td>quantity required: {{$order->showquantiy($order->order_quantity/$food->buffet_div_no)}}</td>
                        @endif
                    @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            
        </div>
    </div>
</div>



@endsection