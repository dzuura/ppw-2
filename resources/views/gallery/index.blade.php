@extends ('auth.layouts')

@section('content')
<a href="{{ route('gallery.create') }}" class="btn btn-primary btn-sm">Tambah Gallery</a>
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Dashboard</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if (count($galleries) > 0)
                            @foreach ($galleries as $gallery)
                                <div class="col-sm-3 mb-4">
                                    <div class="card">
                                        <a class="example-image-link" href="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                                            data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                            <img class="example-image img-fluid mb-2"
                                                src="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                                                alt="image-1" />
                                        </a>
                                        <div class="card-body text-center">
                                            <p>{{ $gallery->title }}</p>
                                            <p>{{ $gallery->description }}</p>
                                            <!-- Edit and Delete Buttons -->
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-secondary btn-sm me-2">Edit</a>
                                                <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3 class="text-center">Tidak ada data.</h3>
                        @endif
                        <div class="d-flex">
                            {{ $galleries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
