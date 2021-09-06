@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('menus.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.menus.create_title')
            </h4>

            <x-form
                method="POST"
                action="{{ route('menus.store') }}"
                has-files
                class="mt-4"
            >
                @include('app.menus.form-inputs')
                
                <!-- new html code here start -->
<div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
               
                <table class="table table-bordered table-hover" id="main_table">
                    <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> Select Food </th>
                            <th class="text-center"> Select Qantity </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id='possition-0'>
                            <td>1</td>
                            <td> <select name='food_new[]' id="" class="form-control food_new">
                            @foreach($foods as $value => $label)
                                <option value="{{ $value }}" >{{ $label }}</option>
                             @endforeach
                            </select></td>
                            <td><input type="number" name='quantity[]' placeholder='0.00' class="form-control quantity" /></td>
                            <td class="add_menu">Add Menu</td>
                            <td><button class="add_menu">Add New row</button></td>
                            <td><button class="delete_menu">Delete row</button></td>
                            
                        </tr>
                        <tr id='possition-1'></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <button id="add_row" class="btn btn-default pull-left" type="button">Add Row</button>
                <button id='delete_row' class="pull-right btn btn-default"  type="button">Delete Row</button>
            </div>
        </div>
       
    </div>
<!-- new html code here end -->
                
                <div class="mt-4">
                    <a href="{{ route('menus.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <button type="button" class="btn btn-primary float-right" id="menu_ok"> 
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.create')
                    </button>
                    
                </div>
            </x-form>
        </div>
    </div>
</div>
<script>
     $(document).ready(function() {
                      
         
         var new_possition = 1;
            $(document).on('click', '.add_menu' ,function(e){
                e.preventDefault();
                back_possition = new_possition - 1;
                $('#possition-' + new_possition).html($('#possition-' + 0).html()).find('td:first-child').html(new_possition + 1);
                $('#main_table').append('<tr id="possition-' + (new_possition + 1) + '"></tr>');
                new_possition++;
            });

            $("#delete_row").click(function() {
                if (new_possition > 1) {
                    $("#possition-" + (new_possition - 1)).html('');
                    new_possition--;
                }
            });
            
            
            $(document).on('click', '.delete_menu', function(e){
                e.preventDefault();
                console.log('click');
                $(this).parent().parent().remove();
            });
            
            $("#menu_ok").click(function(){
               
            var name= $("input[name='name']").val();
            var menu_starts= $("input[name='menu_starts']").val();
            var validity= $("input[name='validity']").val();
            var menu_types_id= $("#menu_types_id").val();
            var meal_type_id= $("#meal_type_id").val();
            var company_id= $("#company_id").val();
            
            var i=0;
            var food_arr=[];
            var quantity_arr=[];
                
                $('#main_table tbody tr').each(function(i, element) {
                var html = $(this).html();
                if (html != '') {
                    var food_new = $(this).find('.food_new').val();
                    var quantity_new = $(this).find('.quantity').val();
                    food_arr[i]=food_new;
                    quantity_arr[i]=quantity_new;
                    
                    i++;
                   
                }
            });
           
            if(food_arr.length>=1){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                //alert(name+" / "+menu_starts+" / "+validity+" / "+menu_types_id+" / "+meal_type_id+" / "+company_id+" / "+food_arr);
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/insert-menu',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, name:name, menu_starts:menu_starts,validity:validity,menu_types_id:menu_types_id,meal_type_id:meal_type_id,food:food_arr,company_id:company_id,quantity:quantity_arr},
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
