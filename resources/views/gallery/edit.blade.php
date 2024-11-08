@extends('auth.layouts')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success position-relative">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                style="position: absolute; right: 10px; top: 10px;"></button>
        </div>
    @endif

    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Edit Gallery</div>
                <div class="card-body">
                    <form action="{{ route('gallery.update', $edit->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" class="form-control" id="id" name="id" value="{{ $edit->id }}">

                        <div class="mb-3 row">
                            <label for="title" class="col-md-4 col-form-label text-md-end text-start">Title</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                    value="{{ $edit->title }}" required>
                                @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" value="{{ $edit->description }}" required>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="picture" class="col-md-4 col-form-label text-md-end text-start">Picture</label>
                            <div class="col-md-6">
                                <input type="hidden" name="oldImage" value="{{ $edit->picture }}">
                                <input type="file" class="form-control @error('picture') is-invalid @enderror" id="picture"
                                    name="picture" value="{{ $edit->picture }}">
                                @error('picture')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Update Gallery</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
