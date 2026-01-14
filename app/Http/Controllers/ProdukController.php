<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $products = [
            ['name' => 'Laptop', 'price' => 1500, 'stock' => 10],
            ['name' => 'Keyboard', 'price' => 50, 'stock' => 25],
            ['name' => 'Mouse', 'price' => 30, 'stock' => 50],
        ];

        return view('products', compact('products'));
    }
}
