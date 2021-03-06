@extends('layouts.app')

@section('content')

<!-- new html code here start -->
<div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <select name="menu_id" id="food_menu" class="form-control">
                     <option disabled selected value="">Please select the menu</option>
                      @foreach($menus as $value => $menu)
                      <option value="{{ $menu->id }}"  >{{ $menu->name }}</option>
                      @endforeach
                </select>

                <select name="company_id_2" id="company_id_2" class="form-control">
                     <option disabled selected value="">Please select the Company</option>
                      @foreach($companies as $value => $label)
                      <option value="{{ $value }}"  >{{ $label }}</option>
                      @endforeach
                </select>
                
              
                
                <br><br>
                <table class="table table-bordered table-hover" id="main_table">
                    <thead>
                        <tr id="food_table">
                            <th class="text-center"> # </th>
                            <th class="text-center"> Customer </th>
                            <th class="text-center"> Total Customer </th>
                            @foreach ($foods as $food)
                            <th class="text-center" id="food_list"> {{ $food->name }} </th>
                            @endforeach
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        @foreach ($orders as $order)
                        <tr id='possition-0'>
                            <td>{{$order->id}}</td>
                            <td>
                                <select name="customer_name[]" id="">-
                                    @foreach ($order->customer()->get() as $customers)
                                    <option value="{{$customers->id}}">{{$customers->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>{{$order->order_quantity}}</td>
                            @foreach ($foods as $food)
                            <td id="food_row">
                                @foreach ($food->menu()->get() as $menus)
                                    @foreach ($menus->orders()->get() as $orderss)
                                    <p>{{$orderss->id == $order->id ? $orderss->showquantiy($orderss->order_quantity/$food->div_no):''}}</p>
                                    @endforeach
                                @endforeach
                            </td>
                               
                            @endforeach
                         
                        </tr>
                        <tr id='possition-1'></tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                        <td></td>
                        <td>{{$orders->count()}}</td>
                        <td>{{$orders->sum('order_quantity')}}</td>
                        @foreach ($foods as $food)
                        <th>{{$food->ordercount()}}</th>
                         @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
   
    </div>
<!-- new html code here end -->


<script>
    
     
     
     
     $(document).ready(function(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $("input[name='price'],input[name='quantity']").on('keyup change', function() {
              var price= $("input[name='price']").val();
              var quantity= $("input[name='quantity']").val();
              var total=0;
              if(price === '' || price === null){
                 price= 0;
               }
               if(quantity === '' || quantity === null){
                 quantity= 1;
               }
               total=price*quantity;
               $("input[name='total']").val(total);
            
            });
           
            $("#food_menu").on('change',function(e){
                window.location = "{{route('stocks.create')}}" + '?'+'menu_id=' + e.target.value;
                 
              
            });
            
            $("#order_ok").click(function(){
                var name= $("input[name='name']").val();
            var price= $("input[name='price']").val();
            var quantity= $("input[name='quantity']").val();
            var total= price*quantity; //$("input[name='total']").val();
            var stock= $("input[name='stock']").val();
            var company_id= $('#company_id').val();
              
              
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/abc',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, name:name, price:price,quantity:quantity,total:total,stock:stock,company_id:company_id},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                        //$(".writeinfo").append(data.msg); 
                        alert(data);
                    }
                }); 
            });
            
       });    
</script>
<!-- here jquery new code  start here -->
<script>
        $(document).ready(function() {
            var new_possition = 1;
            $(document).on('click', '.add_food' ,function(){
               
                console.log('click');
                back_possition = new_possition - 1;
                forward_possition = new_possition + 1;
                $('#possition-' + new_possition).html($('#possition-' + 0).html()).find('td:first-child').html(new_possition + 1);
                $('#main_table').append('<tr id="possition-' + (new_possition + 1) + '"></tr>');
                new_possition++;
            });
            
            $(document).on('click', '.delete_row', function(){
                $(this).parent().parent().remove();
            });
            
            $("#delete_row").click(function() {
                if (new_possition > 1) {
                    $("#possition-" + (new_possition - 1)).html('');
                    new_possition--;
                }
                calc();
            });

            $('#main_table tbody').on('keyup change', function() {
                calc();
            });
            
            $('#tax').on('keyup change', function() {
                calc_total();
            });

            //main function
            $("#call_ajax_btn").click(function() {
                var i=0;
                var price_arr=[];
                var quantity_arr=[];
                var product_arr=[];
                var stock_arr=[];
                
                $('#main_table tbody tr').each(function(i, element) {
                var html = $(this).html();
                if (html != '') {
                    var quantity = $(this).find('.quantity').val();
                    var price = $(this).find('.price').val();
                    var product = $(this).find('.product').val();
                    var stock = $(this).find('.stock').val();
                    
                     price_arr[i]=price;
                     quantity_arr[i]=quantity;
                     product_arr[i]=product;
                     stock_arr[i]=stock;
                     
                    i++;
                   
                }
            });

            if(price_arr.length>=1){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                
                var company_id_2= $('#company_id_2').val();
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/xyz',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, name:product_arr, price:price_arr,quantity:quantity_arr,stock:stock_arr,company_id:company_id_2},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                        //$(".writeinfo").append(data.msg); 
                        console.log(data);
                    }
                }); 
            }
            
            
            
            });
            

        });

        function calc() {
            $('#main_table tbody tr').each(function(i, element) {
                var html = $(this).html();
                if (html != '') {
                    var quantity = $(this).find('.quantity').val();
                    var price = $(this).find('.price').val();
                    $(this).find('.total').val(quantity * price);
                    
                    calc_total();
                }
            });
        }
        
        function calc_total() {
            total = 0;
            $('.total').each(function() {
                total += parseInt($(this).val());
            });
            $('#sub_total').val(total.toFixed(2));
            tax_sum = total / 100 * $('#tax').val();
            $('#tax_amount').val(tax_sum.toFixed(2));
            $('#total_amount').val((tax_sum + total).toFixed(2));
        }

    </script>
    <!-- jquery new code end here -->
@endsection
