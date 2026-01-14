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

        return view('products', compact('products'));
    }
}
