@extends('layouts.app')

@section('content')
      

      
      <style>
          .box{
              border: 1px solid #ddd;
              padding: 10px;
          }
      </style>
      <div class="container">
          <div class="row">
              <div class="col-lg-6">
              
                <form action="{{route('orderfilter')}}" method="GET">
                    @csrf
                    <select name="date" id="">
                    @foreach ($odersdate as $i=>$orderdate )
                        <option value="{{$orderdate->delivery_date}}">{{$orderdate->delivery_date->toDateTimeString()}}</option>
                        @endforeach
                    </select>
                    <button type="submit">Submit</button>
                </form>
              </div>
          </div>
      </div>
    
      <div class="container">
          <div class="row">
          @foreach ($orders as $i=>$order )
              <div class="col-lg-6">
              <div class="box print" id="printable{{$order->id}}">
                <div class="customer">
                    <h2>Name: {{$order->customer->name}}</h2>
                    <h2>Quanity: {{$order->order_quantity}}</h2>
                    <p>Delivery date: {{ $order->delivery_date }}</p>
                    <p>
                        {{ $order->customer->id }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
</div>
          <div class="container">
              <div class="row">
                  <div class="col-lg-6">
                  <input type="button" onclick="printable()" value="Print">
                  </div>
              </div>
          </div>
      
          <script>
              function printable(){
                let printable = document.querySelectorAll('.print');

                printable.forEach(function(print, index){
                    var printContents = print.innerHTML;
                    var originalContents = document.body.innerHTML;
                    
                    document.body.innerHTML = printContents;
                    
                    window.print();
                    
                    document.body.innerHTML = originalContents;
                })
                
              
              }
          </script>


@endsection