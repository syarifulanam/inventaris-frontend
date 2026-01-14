@extends('layouts.app')

@section('content')
    <div class = "d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Products</h1>
        <a href="/products/create" class="btn btn-success">Add</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>${{ $product['price'] }}</td>
                    <td>{{ $product['stock'] }}</td>
                    <td>{{ $product['created_at'] ?? '' }}</td>
                    <td>{{ $product['updated_at'] ?? ' ' }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-primary">Jual</a>
                        <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
