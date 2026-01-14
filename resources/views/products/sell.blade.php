@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Sell Product</h4>
            <a href="/products" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!empty($product))
                <div class="mb-3">
                    <div><strong>Name:</strong> {{ $product['name'] ?? '-' }}</div>
                    <div><strong>Stock:</strong> {{ $product['stock'] ?? '-' }}</div>
                    <div><strong>Price:</strong> {{ $product['price'] ?? '-' }}</div>
                </div>
            @endif

            <form action="{{ route('products.sell', ['id' => $productId]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="qty" min="1" class="form-control" value="{{ old('qty', 1) }}">
                </div>
                <button type="submit" class="btn btn-primary">Sell</button>
            </form>
        </div>
    </div>
@endsection
