@extends('layouts.app')

@section('content')
    

    
    @php
    $numberofsticker = $order->order_quantity/$sticker
    
    @endphp
   
        
    @for($i = 1; $i<=round($numberofsticker); $i++)
        <div class="container printable">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2>Customer Name : {{$order->customer->name}}</h2>
                        </div>
                        <div class="col-lg-6">
                            <h2>Customer No : {{$order->customer->id}}</h2>
                        </div>
                    </div>
                    <h2>Date: {{$order->delivery_date}} {{$i}}</h2>
                </div>
            </div>
        </div>
    
    @endfor
    
    
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
            <input type="button" onclick="printable()" value="Print">
            </div>
        </div>
    </div>

    <script>
              function printable(){
                let printable = document.querySelectorAll('.printable');

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