@extends('auth.layouts')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="row" id="gallery-container">
                        <!-- Data dari API akan dimuat di sini -->
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('gallery.create') }}" class="btn btn-primary d-block mt-2">Add Image</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            loadGalleries();

            // Fungsi untuk memuat data gallery dari API
            function loadGalleries() {
                $.ajax({
                    url: '{{ url('/api/galleries') }}', // URL API
                    method: 'GET',
                    success: function(response) {
                        const galleries = response.data.data; // Sesuaikan dengan struktur data API
                        $('#gallery-container').empty(); // Kosongkan kontainer

                        if (galleries.length > 0) {
                            galleries.forEach(function(gallery) {
                                $('#gallery-container').append(`
                                    <div class="col-sm-3 mb-4">
                                        <div class="card">
                                            <a href="{{ asset('storage/posts_image/') }}/${gallery.picture}"
                                                class="example-image-link" data-lightbox="roadtrip"
                                                data-title="${gallery.description}">
                                                <img src="{{ asset('storage/posts_image/') }}/${gallery.picture}" alt="${gallery.title}"
                                                    class="example-img img-fluid mb-2">
                                            </a>
                                            <div class="card-body text-center">
                                                <p>${gallery.title}</p>
                                                <p>${gallery.description}</p>
                                                <div class="d-flex justify-content-center">
                                                    <a href="/gallery/${gallery.id}/edit" class="btn btn-sm btn-warning me-2">Edit</a>
                                                    <form action="/gallery/${gallery.id}" method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });
                        } else {
                            $('#gallery-container').append(
                                '<h3 class="text-center">Tidak ada data.</h3>');
                        }
                    },
                    error: function() {
                        $('#gallery-container').append(
                            '<h3 class="text-center text-danger">Terjadi kesalahan saat memuat data.</h3>'
                            );
                    }
                });
            }

            // Fungsi untuk menangani penghapusan data menggunakan AJAX
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                if (confirm('Are you sure?')) {
                    const form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function() {
                            loadGalleries(); // Reload data setelah penghapusan berhasil
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat menghapus data.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
