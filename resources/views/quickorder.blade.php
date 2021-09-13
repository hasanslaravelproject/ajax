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
                        <input type="text" value="{{ $last_order->id + 1 }}" disabled>
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
                </tr>
            </thead>
            <tbody id="addedbox">
                
                
                
                
                
                </tbody>
            </table>
            <button type="submit">Submit</button>
        </form>
    </div>
    </div>
</div>



<script>

    
    $('.select').on('change', function(){
        if($(this).prop('checked') === true){
            $('#addedbox').append(
            ` <tr id='${$(this).attr('value')}'>
                    <td>${$(this).attr('data-name')}</td>
                    <input type="hidden" value="${this.value}" name="customer_id[]">
                    <td><input name="quantity[]" type="text"></td>
                </tr>`
        )
        }else{
            console.log($($(this).attr('data-id')).remove());
            
        }
      
    })

</script>
@endsection