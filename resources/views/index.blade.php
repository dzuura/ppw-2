<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Buku</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- Tombol Tambah Buku -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Daftar Buku</h1>
            <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
        </div>

        <!-- Tabel Buku -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Harga</th>
                        <th>Tanggal Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_buku as $buku)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ "Rp. ".number_format($buku->harga, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d-m-Y') }}</td>
                        <td>
                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin mau di hapus?')" type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('buku.edit', $buku->id) }}" method="get">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Edit</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Informasi Jumlah Data dan Total Harga -->
        <div class="mt-3">
            <p><strong>Jumlah Data:</strong> {{ $jumlah }}</p>
            <p><strong>Jumlah Harga:</strong> {{ "Rp ".number_format($total_harga, 2, ',', '.')}}</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>