<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $baseUrl = config('services.api_backend_url');
            $url = $baseUrl . '/api/products';
            $response = Http::timeout(5)->get($url);
            $payload = $response->ok() ? $response->json() : null;
            $products = $payload['data'] ?? [];
        } catch (\Throwable $e) {
            $products = [];
        }

        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
        ]);

        try {
            $baseUrl = config('services.api_backend_url');
            $url = rtrim($baseUrl, '/') . '/api/products';

            $response = Http::timeout(5)
                ->asJson()
                ->post($url, [
                    'name' => $validated['name'],
                    'stock' => (int) $validated['stock'],
                    'price' => (int) $validated['price'],
                ]);

            if ($response->ok()) {
                $payload = $response->json();
                if ($payload['success' ?? false] == true) {
                    return redirect('/products')->with('status', $payload['message'] ?? 'Product created successfully');
                }
            }

            $payload = $response->json();
            $errors = $payload['errors'] ?? [];
            return back()->withErrors($errors)->withInput();
        } catch (\Throwable $e) {
            return back()->withErrors(['Unexpected error, please try again'])->withInput();
        }
    }

    public function create()
    {
        return view('products.create');
    }

    public function sell(Request $request, $id)
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        try {
            $baseUrl = rtrim(config('services.api_backend_url'), '/');
            $url = $baseUrl . "/api/products/{$id}/sell";

            $response = Http::timeout(5)
                ->asJson()
                ->post($url, [
                    'qty' => (int) $validated['qty'],
                ]);

            if ($response->ok()) {
                $payload = $response->json();
                if (($payload['success'] ?? false) === true) {
                    return redirect('/products')->with('status', $payload['message'] ?? 'Produk berhasil dijual');
                }
            }

            if ($response->status() === 422) {
                $payload = $response->json();
                $errors = $payload['errors'] ?? [];
                return back()->withErrors($errors)->withInput();
            }

            $message = $response->json('message') ?? 'Gagal menjual produk';
            return back()->withErrors([$message])->withInput();
        } catch (\Throwable $e) {
            return back()->withErrors(['Unexpected error, please try again.'])->withInput();
        }
    }

    public function sellCreate($id)
    {
        // Optional: fetch product detail if needed for display
        try {
            $baseUrl = rtrim(config('services.api_backend_url'), '/');
            $url = $baseUrl . "/api/products/{$id}";
            $response = Http::timeout(5)->get($url);
            $product = $response->ok() ? ($response->json('data') ?? null) : null;
        } catch (\Throwable $e) {
            $product = null;
        }

        return view('products.sell', [
            'productId' => $id,
            'product' => $product,
        ]);
    }
}
