@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Change Role</h4>
            <a href="/users" class="btn btn-outline-secondary btn-sm">Back</a>
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

            <div class="mb-3">
                <div><strong>Name:</strong> {{ $user['name'] ?? '-' }}</div>
                <div><strong>Email:</strong> {{ $user['email'] ?? '-' }}</div>
                <div><strong>Current Role:</strong> {{ $user['role']['role'] ?? '-' }}</div>
            </div>

            <form action="{{ route('users.change-role', ['id' => $user['id']]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">New Role</label>
                    <select name="role_id" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role['id'] ?? '' }}"
                                {{ ($user['role_id'] ?? '') == ($role['id'] ?? '') ? 'selected' : '' }}>
                                {{ $role['role'] ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Role</button>
            </form>
        </div>
    </div>
@endsection
