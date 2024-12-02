@extends('auth.layouts')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">User List</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userss as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            @if ($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" width="100px" alt="User  Photo"
                                    class="mx-auto">
                            @else
                                <img src="{{ asset('noimage.jpg') }}" width="100px" alt="No Image">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
