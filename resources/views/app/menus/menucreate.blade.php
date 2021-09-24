@extends('layouts.app')

@section('content')
    
    <form action="{{route('menus.storedata')}}" method="POST">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <label for="menuid">Menu Id</label>
                <input type="text" name="menuid" value="{{!empty($menuid->id) ? $menuid->menuid + 1 : 1}}" disabled>
            </div>
            <div class="col-lg-6">
                <label for="menustatus">Menu Status</label>
                <a href="">Active</a>
            </div>
        </div>
    </div>

    
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
               
                <table class="table table-bordered table-hover" id="main_table">
                    <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center">Item </th>
                            <th class="text-center"> Amount </th>
                            <th class="text-center"> Measured Unit </th>
                            <th class="text-center"> Number of Person </th>
                            <th class="text-center"> Per Person Amount </th>
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
                            <td><input type="text" onkeyup="test(this)" name='quantity[]' placeholder='0.00' class="form-control quantity" /></td>
                            
                            <td>
                                <select name="measured_unit[]" id="" class="form-control">
                                @foreach ($measureunit as $unit)
                                <option value="{{$unit->name}}">{{$unit->name}}</option>
                                @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" onkeyup="person(this)" name="person_number[]" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="per_person_amount[]" class="form-control pa">
                            </td>
                            
                            <td><button class="add_menu">Add New row</button></td>
                            <td><button class="delete_menu">Delete row</button></td>
                            
                        </tr>
                        <tr id='possition-1'></tr>

                        
                    </tbody>
                </table>

                <button type="submit">Submit</button>
            </div>
        </div>
     
       
    </div>
            </div>
        </div>
    </div>
</form>
    <script>
        let amount;
        let persons;
        let total;
        
        function calculate(){
           /*  total = Math.ceil(amount/persons);
            if(total == Infinity || total == 'NaN'){
                total = 0;
            } */
            total = amount/persons;
            
            
        }
        
        function test($this){
            amount = ($this.value);
            calculate()
            console.log($($this).closest('td').next('td').next('td').next('td').find('input').val(total));
        }
        
        function person($this){
           persons = $this.value;
           calculate()
           console.log($($this).closest('td').next('td').find('input').val(total) );
        }
     $(document).ready(function() {
         var new_possition = 1;
            $(document).on('click', '.add_menu' ,function(e){
                e.preventDefault();
                amount = 0;
                persons = 0;
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
