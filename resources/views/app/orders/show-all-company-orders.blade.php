@extends('layouts.app')

@section('content')
<div class="container">
  
  
  @foreach($Order_Detail as $Order_Detail)
  <div class="card">
    <h1 class="text-center">{{ $Order_Detail->customer->name }}</h1>
    <br><br>
    <div class="container">
      <p>Total Orders: {{$Order_Detail->count()}}</p>
      <form action="{{url('show-company-orders-delivery-date')}}" method="post">
        @csrf
        <select name="company_id_search" id="" class="form-control" required>
          <option value="" selected="" disabled="">Select delivery_date </option>
          @foreach ($Order_Detail_options as $Order_Detail_option)
          <option value="{{$Order_Detail_option->delivery_date}}">{{$Order_Detail_option->delivery_date}}</option>
          @endforeach
        </select>
        <button type="submit" name="submit" class="btn btn-success">Search</button>
      </form>
      <a href="{{url('orders/create')}}">Back</a>
      @php $i=0 @endphp
      <br><br><br>
      <table class="table table-bordered table-striped" id="print{{$i}}">
        <thead>
          <tr>
            <th>Order id # {{$Order_Detail->id }}</th>
            <th></th>
            <th>Order delivery_date # {{$Order_Detail->delivery_date }}</th>
          </tr>
          <tr>
            <th>Food name</th>
            <th>Food Quantity</th>
            <th>Menu Id</th>
          </tr>
        </thead>
        <tbody id="myTable">
          @foreach($Food_Detail as $Food_Detail)
          @foreach($order_food_details as $order_food_detail)
          @if($order_food_detail->order_id==$Order_Detail->id && $order_food_detail->food_id==$Food_Detail->id)
          <tr>
            <td>{{$Food_Detail->name}}</td>
            <th>{{$order_food_detail->food_quantity}}</th>
            <th>{{$order_food_detail->menu_id}}</th>
          </tr>
          @endif
          @endforeach
          @endforeach
          <tr>
            <td></td>
            <td></td>
            <td><button onclick="printContent('print{{$i}}');">Print</button></td>
          </tr>
        </tbody>
      </table>
      @php $i++ @endphp
      @endforeach
      <p>Note that we start the search in tbody, to prevent filtering the table headers.</p>
    </div>
  </div>
</div>
<script>
  function printContent(el) {
    var restorepage = $('body').html();
    var printcontent = $('#' + el).clone();
    $('body').empty().html(printcontent);
    window.print();
    $('body').html(restorepage);
  }
</script>
@endsection