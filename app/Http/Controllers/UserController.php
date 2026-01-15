<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        try {
            $baseUrl = config('services.api_backend_url');
            $url = rtrim($baseUrl, '/') . '/api/users';

            $response = Http::timeout(5)->get($url);
            $payload = $response->ok() ? $response->json() : null;

            $users = $payload['data'] ?? [];
        } catch (\Throwable $e) {
            $users = [];
        }

        // $users = [
        //     ['name' => 'Alice', 'email' => 'alice@example.com', 'role' => 'Admin'],
        //     ['name' => 'Bob', 'email' => 'bob@example.com', 'role' => 'User'],
        //     ['name' => 'Charlie', 'email' => 'charlie@example.com', 'role' => 'Manager'],
        // ];

        return view('users.index', compact('users'));
    }

    public function create()
    {
        try {
            $baseUrl = rtrim(config('services.api_backend_url'), '/');
            $response = Http::get($baseUrl . '/api/roles');

            $payload = $response->ok() ? $response->json() : null;
            $roles = $payload['data'] ?? [];
        } catch (\Throwable $e) {
            $roles = [];
        }

        return view('users.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id'  => $validated['role_id'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }
    // return view('users', compact('users'));
}
