@extends('layouts.mainadmin')
@section('title', 'Tentang admin ')


@section('contents')
    <div class="d-flex justify-content-center align-items-center vh-15">
        <img src="{{ asset('tentang.png') }}" class="img-fluid" style="width:200px">
    </div>

    <div class="d-flex pt-5">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="fw-semibold fs-4">List tentang</h2>
            <a href="{{ route('tentangs.create') }}" class="btn btn-primary btn-sm px-3 py-1">Tambah</a>
        </div>
    </div>
    <br><br><br>

    <div class="mt-4">
        <form action="{{-- {{ route('galeris.index') }} --}}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari tentang..."
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
        </form>
    </div>
    <br><br><br>


    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
            aria-label="Close"></button>
    </div>
@endif

    @if (isset($tentangs) && $tentangs->isEmpty())
        <div class="alert alert-info mt-4">
            Tidak ada tentang yang ditemukan "{{ request('search') }}".
        </div>
    @endif

    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($tentangs as $tentang)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $tentang->judul }}</h5>
                            <p class="card-text flex-grow-1 text-secondary">{{ $tentang->deskripsi }}</p>
                            <p class="text-muted fw-bold fs-6 mb-3">{{ $tentang->tanggal->format('d-m-Y') }}</p>
                            <a href="{{ route('tentangs.edit', $tentang) }}"
                                class="btn btn-outline-primary w-100 mt-auto">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">
            {{ $tentangs->links() }}
        </div>
    </div>
@endsection
