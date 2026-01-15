@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Add User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role_id" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role['id'] ?? '' }}">
                        {{ $role['role'] ?? '-' }}
                    </option>
                @endforeach
            </select>

        </div>

        <div class="d-flex justify-content-between">
            <a href="/users" class="btn btn-outline-secondary">Back</a>
            <button type="submit" class="btn btn-primary">
                Save
            </button>
        </div>
    </form>
@endsection
