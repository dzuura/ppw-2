@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                @if ($message = Session::get('success_age'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @elseif($message = Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @endif

                @if (auth()->user()->level === 'admin')
                    <a href="{{ URL('/admin') }}" class="d-block"><button>Go to Admin</button></a>
                @elseif(auth()->user()->level === 'user')
                    <a href="{{ URL('/dashboard') }}"></a>
                    Selamat datang di halaman User
                @elseif(auth()->user()->level === 'guest')
                    <a href="{{ URL('/dashboard') }}"></a>
                    Selamat datang di halaman Guest
                @endif
            </div>
        </div>
    </div>
</div>

@endsection