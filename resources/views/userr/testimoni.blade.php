@extends('layouts.main')
@include('layouts.navbar')
@section('title', 'Testimoni')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }
    .mtitle {
        font-size: 2rem;
        font-weight: bold;
        text-align: center;
        margin-top: 50px;
    }
    </style>

        <div class="container pt-5 my-5">
            <h2 class="mtitle">Testimoni</h2>
<br>


@if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

    @auth
        @if (auth()->user()->role == 'user')
            <a href="{{ route('testimoni.create') }}" class="btn btn-primary mb-5 ">
                <i class="fas fa-plus"></i> Tambah Testimoni
            </a>
        @endauth
    @else
        <div class="alert alert-info ">
            <p>Login terlebih dahulu jika ingin menambahkan ulasan.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    @endif

    <div class="row">
        @foreach ($testimonis as $testimoni)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/img/profil.jpg') }}" alt="Profile" class="rounded-circle me-3" width="50" height="50"> {{-- kita gas buat fitur barU --}}
                            <div>
                                <h5 class="card-title mb-0">{{ $testimoni->nama }}</h5>
                                <small class="text-muted">{{ $testimoni->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $testimoni->rating)
                                    <span class="fa fa-star" style="color: gold;"></span>
                                @else
                                    <span class="fa fa-star" style="color: #ddd;"></span>
                                @endif
                            @endfor
                        </div>
                        <p class="card-text">{{ $testimoni->deskripsi }}</p>
                    </div>
                    @auth
                        @if (auth()->user()->role == 'user' && auth()->user()->id == $testimoni->user_id)
                            <div class="card-footer bg-transparent border-top-0">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('testimoni.edit', $testimoni->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('testimoni.destroy', $testimoni->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
</div>

@include('layouts.footer')
