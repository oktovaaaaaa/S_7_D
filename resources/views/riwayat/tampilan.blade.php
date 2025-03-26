@extends('layouts.mainadmin')
@section('title', 'Riwayat admin')


@section('contents')
    <div class="container text-center pt-5 my-5">
        <h1>Riwayat Pesanan</h1>


        <div class="mt-4">
            <form action="{{ route('riwayat.tampilan') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari riwayat pemesanan..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
            </form>
        </div>
        <br>

        @if (isset($riwayats) && $riwayats->isEmpty())
        <div class="alert alert-info mt-4">
            Tidak ada testimoni yang ditemukan "{{ request('search') }}".
        </div>
        @endif

        <table class="table pt-5 my-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama User</th> <!-- Ganti User ID dengan Nama User -->
                    <th>Daftar Menu</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($semuaRiwayatPesanan as $pesanan)
                    <tr>
                        <td>{{ $pesanan->id }}</td>
                        <td>{{ $pesanan->user->name }}</td> <!-- Tampilkan nama user -->
                        <td>
                            <ul>
                                @foreach(json_decode($pesanan->daftar_menu, true) as $menu)
                                    <li>{{ $menu['nama'] }} ({{ $menu['jumlah'] }} x Rp {{ number_format($menu['harga_satuan'], 0, ',', '.') }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $pesanan->status }}</td>
                        <td>{{ $pesanan->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
