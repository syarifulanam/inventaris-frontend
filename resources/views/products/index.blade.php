@extends('layouts.app')

@section('content')
    <div class = "d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Products</h1>
        <a href="/products/create" class="btn btn-success">Add</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>Rp{{ $product['price'] }}</td>
                    <td>{{ $product['stock'] }}</td>
                    <td>
                        <a href="/products/{{ $product['id'] }}/sell/create" class="btn btn-sm btn-outline-primary">Sell</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
