@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="order">
                <div class="row">
                    <div class="col-lg-4">
                        <h2>Order</h2>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" value="{{ !empty($last_order->id) ? $last_order->id+1 : 1}}" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="shop-list border">
                <h2>Shop List</h2>
                <div class="boxes">
                    @foreach ($customers as $customer)
                    <input type="checkbox" class="select" name="select" data-id="#{{ $customer->id }}" value="{{ $customer->id }}" data-name="{{$customer->name}}">
                    <label for="vehicle1"> {{$customer->name}}</label><br>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <form  action="{{route('saveorder')}}" method="POST">
                @csrf
            <label for="deliver_date">Delivery</label>
            <input name="delivery_date" type="date">
            <br>
            <div id="totalq">
            
            </div>
            <select name="menu_id" id="">
                @foreach ($menus as $menu)
                <option value="{{$menu->id}}">{{$menu->name}}</option>
                    
                @endforeach
            </select>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Customer Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Food</th>
                <th scope="col">Amount</th>
                
                </tr>
            </thead>
            <tbody id="addedbox">
                
                
                
                
                
                </tbody>
            </table>
            <button type="submit">Submit</button>
        </form>

        <button onclick="countquantity()">Count</button>
        
    </div>
    </div>
</div>

<style>
    .food{
        margin-bottom: 8px;
        display: block;
    }
    .qi{
        margin-bottom: 20px;
    }

    span.full {
        border: 1px solid #000;
        padding: 3px;
    }
    span.half {
        border: 1px solid #000;
        padding: 3px;
    }
</style>


<script>
     
    $('.select').on('change', function(){
        if($(this).prop('checked') === true){
            $('#addedbox').append(
            ` <tr id='${$(this).attr('value')}'>
                    <td>${$(this).attr('data-name')}</td>
                    <input type="hidden" value="${this.value}" name="customer_id[]">
                    <td><input class="quantity" onkeyup="quantityfood(this)" name="quantity[]" type="text"></td>
                    <td>
                   
                    </td>
                    <td>
                    
                    </td>
                    <td style="width:150px">
                        
                    </td>
                    
                </tr>`
        )
        
        }else{
            console.log($($(this).attr('data-id')).remove());
            
        }
      
    })
    
    
       function quantityfood($this){
        $.ajax({
            url: "{{route('orderquantity')}}",
            type: "POST",
            data: {
                quantity: $this.value,
                _token: '{{csrf_token()}}'
            }
            //console.log(data);
        }).done(function(data){
            
            $($this).closest('td').next('td').next('td').empty();
            $($this).closest('td').next('td').empty();
            $($this).closest('td').next('td').next('td').next('td').empty();
            data.test.forEach(function(value, index){
                ($($this).closest('td').next('td').next('td').append(
                    `<input disabled class="qi" type="text" value="${value}">`
                    ));
            })
            data.food.forEach(function(value, index){
                ($($this).closest('td').next('td').append(
                    `<span class="food">${value}  <br></span>`
                    ));
            })
            
            ($($this).closest('td').next('td').next('td').next('td').append(
                    `${data.qd}`
                    ));
                    
        });
       
       }

       
       let countarr = [];
      let sum = 0;
      
      function countquantity(){
          countarr = [];
          sum = 0;
          $('.quantity').each(function(){
              countarr.push(parseInt($(this).val()));
          })
             
        for (let i = 0; i < countarr.length; i++) {
            sum += countarr[i];
        }
        callquantity(countarr)
        }

        

    function callquantity(sum){
        $.ajax({
            url: "{{route('countquantity')}}",
            type: "POST",
            data: {
                quantity: countarr,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data){
            //console.log(data);
            $('#totalq').html(data)
        })
    }
        

        
    
        
      //get all the value
     
      
      
      
</script>
@endsection