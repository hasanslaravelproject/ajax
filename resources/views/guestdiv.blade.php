@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
        <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Customer</th>
      @foreach ($foods as $food)
      <th scope="col">{{$food->name}}</th>
      <th scope="col">Division</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
      @foreach ($foods as $food)
          @foreach ($food->menus()->get() as $menu)
              @foreach ($menu->orders()->get() as $order)
                  
              <tr>
                <th scope="row">1</th>
                @foreach ($order->customer()->get() as $customer)
                <td>{{ $customer->name }}</td>
                @endforeach
               
                @foreach ($foods as $foodss)

                @foreach ($foodss->menus()->get() as $menus)
                    @foreach ($menus->orders()->get() as $orderss)
                    <td>{{$orderss->id == $order->id ? $orderss->order_quantity:''}}</td>
                    <td>{{$orderss->id == $order->id ? $orderss->division($orderss->order_quantity): ''}}</td>
                    @endforeach
                    @endforeach
                                         
                
                
                  
                @endforeach
              
              </tr>
              @endforeach
          @endforeach
      @endforeach
    
  </tbody>
</table>
        </div>
    </div>
</div>



@endsection