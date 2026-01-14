<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = [
            ['name' => 'Alice', 'email' => 'alice@example.com', 'role' => 'Admin'],
            ['name' => 'Bob', 'email' => 'bob@example.com', 'role' => 'User'],
            ['name' => 'Charlie', 'email' => 'charlie@example.com', 'role' => 'Manager'],
        ];

        return view('users', compact('users'));
    }
}
