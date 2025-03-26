@extends('layouts.mainadmin')
@section('title', 'Testimoni admin')

@section('contents')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="container pt-5 my-5 text-center">
        <h1>Daftar Testimoni</h1>

        <div class="mt-4">
            <form action="{{ route('testimonis.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari testimoni..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
            </form>
        </div>
        <br>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


@if (isset($testimonis) && $testimonis->isEmpty())
<div class="alert alert-info mt-4">
    Tidak ada testimoni yang ditemukan "{{ request('search') }}".
</div>
@endif


        @auth
            @if (auth()->user()->role == 'user')
                <a href="{{ route('userr.testimoni.create') }}" class="btn btn-primary mb-3">Tambah Testimoni</a>
            @endauth
        @else
            <a>Login Terlebih dahulu jika ingin menambahkan Ulasan</a>
            <br>
            <a href="{{ route('login') }}" class="btn btn-primary mb-3">Login</a>
        @endif

        <table class="table table-striped pt-5 my-5">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Rating</th>
                    <th>Deskripsi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testimonis as $testimoni)
                    <tr>
                        <td>{{ $testimoni->nama }}</td>
                        <td>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $testimoni->rating)
                                    <span class="fa fa-star" style="color: gold;"></span>
                                @else
                                    <span class="fa fa-star" style="color: black;"></span>
                                @endif
                            @endfor
                        </td>
                        <td>{{ $testimoni->deskripsi }}</td>
                        <td>

                            {{-- <form action="{{ route('userr.testimoni.destroy', $testimoni->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Hapus</button> --}}
                            @include('testimonis.delete')
                            {{-- </form> --}}
                            </li>
                            </ul>
    </div>
    </td>
    </tr>
    @endforeach
    </tbody>
    </table>
    </div>
@endsection
