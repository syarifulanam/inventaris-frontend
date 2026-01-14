@extends('layouts.app')

@section('content')
<h1>Products</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $product['name'] }}</td>
            <td>${{ $product['price'] }}</td>
            <td>{{ $product['stock'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection