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
                        <button type="button" class="btn btn-sm btn-outline-primary"
                            onclick="sellProduct({{ $product['id'] }}, {{ $product['stock'] }})">
                            Sell
                            {{-- <a href="#" class="btn btn-sm btn-outline-danger">Delete</a> --}}
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

<script>
    function sellProduct(id, stock) {
        let qty = prompt("Masukkan jumlah yang dijual:");

        if (qty === null) return;

        qty = parseInt(qty);

        if (isNaN(qty) || qty <= 0) {
            alert("Jumlah tidak valid");
            return;
        }

        if (qty > stock) {
            alert("❌ Stok tidak mencukupi");
            return;
        }

        fetch(`/products/${id}/sell`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    qty: qty
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("✅ Produk berhasil dijual");
                    location.reload();
                } else {
                    alert(data.message || "Gagal menjual produk");
                }
            })
            .catch(() => alert("Server error"));
    }
</script>
