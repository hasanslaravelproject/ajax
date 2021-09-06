@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('orders.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.orders.create_title')
            </h4>
           
            <form action="{{url('show-company-orders')}}" method="post">
                @csrf
                <select name="company_id_search" id="" class="form-control" required>
                    <option value="" selected="" disabled="">Select Company </option>
                     @foreach($customers as $value => $label)
                     <option value="{{ $value }}" >{{ $label }}</option>
                      @endforeach
                </select>
                <button type="submit" name="submit" class="btn btn-success">Search</button>
            </form>
            <x-form
                method="POST"
                action="{{ route('orders.store') }}"
                class="mt-4"
            >
            
                @include('app.orders.form-inputs')
                <div id="show-foods"></div>
                <div class="mt-4">
                    <a href="{{ route('orders.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>
                   
                    <button type="button" class="btn btn-primary float-right" id="order_ok">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.create')
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
      /*  //var today = moment().format('DD-MM-YYYY');
        alert('today');
//$('#delivery_date').val(today);
        

        var now = new Date();

var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);

var today = (day)+"/"+(month)+"/"+now.getFullYear() ;
//alert(today);
$("#delivery_date").val(today);
    */
        const d = new Date();
        var m=d. getMonth() + 1; // Month [mm] (1 - 12)
        var dd=d. getDate(); // Day [dd] (1 - 31)
        var y=d. getFullYear(); // Year [yyyy]
        var date=dd+"-"+m+"-"+y;
        
        //$("input[name='delivery_date']").val("21/08/2021 23.19");



        //here is new code

        //fetch dat
        $(document).on('change','#menu_id',function(){
            var menu_id=$(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                    /* the route pointing to the post function */
                    url: '/fetch-food-menu-ajax',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, menu_id:menu_id},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {  
                        // console.log(data);
                        $('#show-foods').html(" ");
                        $('#show-foods').append(data);
                    }
                }); 
        });


        // insert data
        $("#order_ok").click(function(){
               
               var delivery_date= $("input[name='delivery_date']").val();
               var order_quantity= $("input[name='order_quantity']").val();
               var customer_id= $("#customer_id").val();
               var menu_id= $("#menu_id").val();
               
               var i=0;
               var food_arr=[];
               var quantity_arr=[];
                   
                   $('#food_menu_table tbody tr').each(function(i, element) {
                   var html = $(this).html();
                   if (html != '') {
                       var food_new = $(this).find('.food_id').val();
                       var quantity_new = $(this).find('.food_quantity').val();
                       food_arr[i]=food_new;
                       quantity_arr[i]=quantity_new;
                       
                       i++;
                      
                   }
               });
               
              
               if(food_arr.length>=1){
                   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                //    alert(delivery_date+" / "+order_quantity+" / "+customer_id+" / "+menu_id+" / "+food_arr+" / "+quantity_arr);
                   $.ajax({
                       /* the route pointing to the post function */
                       url: '/insert-order',
                       type: 'POST',
                       /* send the csrf-token and the input to the controller */
                       data: {_token: CSRF_TOKEN, delivery_date:delivery_date, order_quantity:order_quantity,customer_id:customer_id,menu_id:menu_id,food_arr:food_arr,quantity_arr:quantity_arr},
                       dataType: 'JSON',
                       /* remind that 'data' is the response of the AjaxController */
                       success: function (data) { 
                           //$(".writeinfo").append(data.msg); 
                           alert(data);
                       }
                   }); 
                }
               });
    });
</script>
@endsection
