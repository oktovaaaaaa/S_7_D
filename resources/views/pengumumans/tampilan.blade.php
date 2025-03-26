@extends('layouts.mainadmin')
@section('title', 'Pengumuman admin')

@section('contents')
    <div class="d-flex justify-content-center align-items-center vh-15">
        <img src="{{ asset('pengumuman.png') }}" class="img-fluid" style="width:200px">
    </div>

    <div class="d-flex pt-5">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="fw-semibold fs-4">List pengumuman</h2>
            <a href="{{ route('pengumumans.create') }}" class="btn btn-primary btn-sm px-3 py-1">Tambah</a>
        </div>
    </div>
    <br><br><br>

    <!-- Form Pencarian -->
    <div class="mt-4">
        <form action="{{-- {{ route('menus.index') }} --}}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari pengumuman..."
                value="{{-- {{ request('search') }} --}}">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
        </form>
    </div>
    <br><br><br>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif



    @if (isset($menus) && $menus->isEmpty())
        <div class="alert alert-info mt-4">
            Tidak ada menu yang ditemukan "{{ request('search') }}".
        </div>
    @endif

    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($pengumumans as $pengumuman)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $pengumuman->judul }}</h5>
                            <p class="card-text flex-grow-1 text-secondary">{{ $pengumuman->teks }}</p>
                            <p class="card-text flex-grow-1 text-secondary">{{ $pengumuman->tautan }}</p>
                            <p class="text-muted fw-bold fs-6 mb-3">{{ $pengumuman->tanggal->format('d-m-Y') }}</p>
                            <a href="{{ route('pengumumans.edit', $pengumuman) }}"
                                class="btn btn-outline-primary w-100 mt-auto">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">
            {{-- {{ $pengumumans->links() }} --}}
        </div>
    </div>
@endsection
