@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <form action="{{route('show-orders')}}" method="POST">
        @csrf
      <div class="form-group">
        <input type="text" class="form-control" name="company_id_search" placeholder="Search by date" value="">
      </div>
      <button type="submit" name="submit" class="btn btn-success">Search</button>
    </form>
  </div>
</div>


@endsection