@extends('layouts.mainadmin')
@section('title', 'Galeri admin')

@section('contents')
    <div class="d-flex justify-content-center align-items-center vh-15">
        <img src="{{ asset('galeri.png') }}" class="img-fluid" style="width:200px">
    </div>

    <div class="d-flex pt-5">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="fw-semibold fs-4">List galeri</h2>
            <a href="{{ route('galeris.create') }}" class="btn btn-primary btn-sm px-3 py-1">Tambah</a>
        </div>
    </div>
    <br><br><br>

    {{-- Form Pencarian --}}
    <div class="mt-4">
        <form action="{{-- {{ route('galeris.index') }} --}}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari galeri..."
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
        </form>
    </div>
    <br><br><br>

    <!-- Tampilkan data galeri di sini -->

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (isset($galeris) && $galeris->isEmpty())
        <div class="alert alert-info mt-4">
            Tidak ada galeri yang ditemukan "{{ request('search') }}".
        </div>
    @endif

    <!-- Pesan Jika Hasil Pencarian Kosong -->
    @if (isset($menus) && $menus->isEmpty())
        <div class="alert alert-info mt-4">
            Tidak ada menu yang ditemukan "{{ request('search') }}".
        </div>
    @endif


    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-6 g-4">
            @foreach ($galeris as $galeri)
                <div class="col">
                    <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
                        <!-- Gambar dengan aspect ratio 1:1 -->
                        <div class="ratio ratio-1x1">
                            <img src="{{ asset('storage/images/' . $galeri->foto) }}"
                                class="card-img-top img-fluid rounded-top-4" alt="galeri Image" style="object-fit: cover;">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $galeri->nama }}</h5>
                            <p class="card-text flex-grow-1">{{ $galeri->deskripsi }}</p>
                            <a href="{{ route('galeris.edit', $galeri) }}"
                                class="btn btn-outline-primary w-100 mt-auto rounded-3">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">
            {{-- {{ $galeris->links() }} --}}
        </div>
    </div>
@endsection
