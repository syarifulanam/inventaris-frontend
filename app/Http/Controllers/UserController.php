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
            $response = Http::timeout(5)->get($baseUrl . '/api/roles');
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
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'role_id'  => 'required|integer',
        ]);

        try {
            $baseUrl = rtrim(config('services.api_backend_url'), '/');
            $url = $baseUrl . '/api/users';

            $response = Http::timeout(5)
                ->asJson()
                ->post($url, [
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'password' => $validated['password'],
                    'role_id'  => (int) $validated['role_id'],
                ]);

            if ($response->ok() || $response->status() === 201) {
                $payload = $response->json();
                if (($payload['success'] ?? false) === true) {
                    return redirect('/users')->with('status', $payload['message'] ?? 'User created successfully');
                }
            }

            if ($response->status() === 422) {
                $payload = $response->json();
                $errors = $payload['errors'] ?? [];
                return back()->withErrors($errors)->withInput();
            }

            $message = $response->json('message') ?? 'Failed to create user';
            return back()->withErrors([$message])->withInput();
        } catch (\Throwable $e) {
            return back()->withErrors(['Unexpected error, please try again.'])->withInput();
        }
    }

    public function changeRoleCreate($id)
    {
        try {
            $baseUrl = rtrim(config('services.api_backend_url'), '/');

            // Fetch user detail
            $userResponse = Http::timeout(5)->get($baseUrl . "/api/users/{$id}");
            $user = $userResponse->ok() ? ($userResponse->json('data') ?? null) : null;

            // Fetch roles
            $rolesResponse = Http::timeout(5)->get($baseUrl . '/api/roles');
            $roles = $rolesResponse->ok() ? ($rolesResponse->json('data') ?? []) : [];
        } catch (\Throwable $e) {
            $user = null;
            $roles = [];
        }

        if (!$user) {
            return redirect('/users')->with('status', 'User not found');
        }

        return view('users.change-role', compact('user', 'roles'));
    }

    public function changeRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role_id' => 'required|integer',
        ]);

        try {
            $baseUrl = rtrim(config('services.api_backend_url'), '/');
            $url = $baseUrl . "/api/users/{$id}/change-role";

            $response = Http::timeout(5)
                ->asJson()
                ->put($url, [
                    'role_id' => (int) $validated['role_id'],
                ]);

            if ($response->ok()) {
                $payload = $response->json();
                if (($payload['success'] ?? false) === true) {
                    return redirect('/users')->with('status', $payload['message'] ?? 'User role updated successfully');
                }
            }

            if ($response->status() === 422) {
                $payload = $response->json();
                $errors = $payload['errors'] ?? [];
                return back()->withErrors($errors)->withInput();
            }

            if ($response->status() === 404) {
                return redirect('/users')->with('status', 'User not found');
            }

            $message = $response->json('message') ?? 'Failed to update user role';
            return back()->withErrors([$message])->withInput();
        } catch (\Throwable $e) {
            return back()->withErrors(['Unexpected error, please try again.'])->withInput();
        }
    }
}
