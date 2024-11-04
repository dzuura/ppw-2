@extends('auth.layouts')

@section('content')
<div class="container mt-4">
    <h2>Edit User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if you don't want to change">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Leave blank if you don't want to change">
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
            @if ($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" width="100px" alt="User  Photo">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection