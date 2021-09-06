<html>

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    

     <!-- load jQuery -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- provide the csrf token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!------ Include the above in your HEAD tag ---------->
</head>

<body>
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="main_table">
                    <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> Product </th>
                            <th class="text-center"> quantity </th>
                            <th class="text-center"> Price </th>
                            <th class="text-center"> Total </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id='possition-0'>
                            <td>1</td>
                            <td><input type="text" name='product[]' placeholder='Enter Product Name' class="form-control" /></td>
                            <td><input type="number" name='quantity[]' placeholder='Enter quantity' class="form-control quantity" step="0" min="0" /></td>
                            <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0" /></td>
                            <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly /></td>
                        </tr>
                        <tr id='possition-1'></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <button id="add_row" class="btn btn-default pull-left">Add Row</button>
                <button id='delete_row' class="pull-right btn btn-default">Delete Row</button>
            </div>
        </div>
        <div class="row clearfix" style="margin-top:20px">
            <div class="pull-right col-md-4">
                <table class="table table-bordered table-hover" id="main_table_total">
                    <tbody>
                        <tr>
                            <th class="text-center">Sub Total</th>
                            <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly /></td>
                        </tr>
                        <tr>
                            <th class="text-center">Tax</th>
                            <td class="text-center">
                                <div class="input-group mb-2 mb-sm-0">
                                    <input type="number" class="form-control" id="tax" placeholder="0">
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">Tax Amount</th>
                            <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly /></td>
                        </tr>
                        <tr>
                            <th class="text-center">Grand Total</th>
                            <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly /></td>
                        </tr>
                    </tbody>
                </table>
                <button id="order_ok">Ok</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var new_possition = 1;
            $("#add_row").click(function() {
                back_possition = new_possition - 1;
                $('#possition-' + new_possition).html($('#possition-' + back_possition).html()).find('td:first-child').html(new_possition + 1);
                $('#main_table').append('<tr id="possition-' + (new_possition + 1) + '"></tr>');
                new_possition++;
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

       /* ;*/
            

            $(document).ready(function(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#order_ok").click(function(){
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/abc',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, name:'name_here', price:'21',quantity:'1',total:'21',stock:'10.00',company_id:'1'},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                        //$(".writeinfo").append(data.msg); 
                        alert(data)
                        
                    }
                }); 
            });
       });    
    </script>

    <!-- For more example like this -->
    <!-- https://bootsnipp.com/snippets/BE93p -->
</body>

</html>