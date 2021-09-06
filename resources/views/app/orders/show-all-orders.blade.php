@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <h1 class="text-center">alkjdlajf</h1>
        <br><br>
        <div class="container">
  <h2>Filterable Table</h2>
  <p>Type something in the input field to search the table for first names, last names or emails:</p>  
  <input class="form-control" id="myInput" type="text" placeholder="Search..">
  <br>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Customer</th>
        <th>Quest</th>
        @foreach($food_details as $food_detail)
        <th>{{$food_detail->name}}</th>
        <th>{{$food_detail->name." Div"}}</th>
        @endforeach
      </tr>
    </thead>
    <tbody id="myTable">
    @php $total_companies=0; @endphp
    @php $food_quantity_arr=array(); @endphp
    @php $total_quest=0; @endphp
    
    @foreach($order_details as $order_detail)
      <tr>
        <td>{{ $order_detail->name }}</td>
        <td>{{ $order_detail->order_quantity }}</td>
        @php $total_quest+=$order_detail->order_quantity; @endphp
        

        @php $total_foods=0; @endphp
        @foreach($food_details as $food_detail)
             @php $food_run=0; @endphp
             @php $total_quantity=0; @endphp
             @foreach($order_food_details as $order_food_detail)
                 @if($order_detail->id==$order_food_detail->order_id && $order_food_detail->food_id==$food_detail->id)
                    @php $total_quantity+=$order_food_detail->food_quantity; @endphp
                    @php $food_run=1; @endphp
                 @endif
             @endforeach
            @if($food_run==1)
            
            @if(empty($food_quantity_arr[$total_foods]))
               @php $food_quantity_arr[$total_foods]=$total_quantity; @endphp
            @else
              @php $food_quantity_arr[$total_foods]+=$total_quantity; @endphp
            @endif
            
            <td> {{$total_quantity}}</td>
            <td> {{$total_quantity/$food_detail->div_no}}</td>
            @else

            @if(empty($food_quantity_arr[$total_foods]))
               @php $food_quantity_arr[$total_foods]=0; @endphp
            @else
              @php $food_quantity_arr[$total_foods]+=0; @endphp
            @endif
            
            <td></td>
            <td></td>
            @endif

            @php $total_foods++; @endphp
        @endforeach

        @php $total_companies++; @endphp
      </tr>
      @endforeach
     <tr>   
         <td>Total Companies: {{ $total_companies }}</td>
         <td>Total Quest :{{ $total_quest }} </td>
         @foreach($food_details as $food_detail)
            <td>Total {{ $food_detail->name }}: {{ $food_quantity_arr[$loop->index] }}</td>
            <td></td>
         @endforeach
     </tr>
    </tbody>
  </table>
  
  <p>Note that we start the search in tbody, to prevent filtering the table headers.</p>
</div>

<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
    </div>
</div>
@endsection
