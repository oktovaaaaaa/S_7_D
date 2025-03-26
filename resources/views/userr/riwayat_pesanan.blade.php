@extends('layouts.main')
    @include('layouts.navbar')
    @section('title', 'Riwayat pemesanan')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000000;
        }
        .mtitle {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-top: 50px;
        }
        </style>

            <div class="container pt-5 my-5">
                <h2 class="mtitle">Riwayat</h2>
    <br>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
            aria-label="Close"></button>
    </div>
@endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(count($riwayatPesanan) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Daftar Menu</th>
                            <th class="text-right">Total Harga</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatPesanan as $pesanan)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($pesanan->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}</td>
                                <td>
                                    @if(is_array(json_decode($pesanan->daftar_menu, true)))
                                        <ul class="list-unstyled">
                                            @foreach(json_decode($pesanan->daftar_menu, true) as $menu)
                                                <li>
                                                    {{ $menu['nama'] }}
                                                    <small>({{ $menu['jumlah'] }} x Rp {{ number_format($menu['harga_satuan'], 0, ',', '.') }})</small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        Tidak ada menu.
                                    @endif
                                </td>
                                <td class="text-right">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($pesanan->status == 'pending')
                                        <span class="badge badge text-dark">{{ ucfirst($pesanan->status) }}</span>
                                    @elseif($pesanan->status == 'diproses')
                                        <span class="badge badge-info">{{ ucfirst($pesanan->status) }}</span>
                                    @elseif($pesanan->status == 'selesai')
                                        <span class="badge badge-success">{{ ucfirst($pesanan->status) }}</span>
                                    @elseif($pesanan->status == 'ditolak')
                                        <span class="badge badge-danger">{{ ucfirst($pesanan->status) }}</span>
                                    @else
                                        {{ ucfirst($pesanan->status) }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('userr.hapusRiwayatPesanan', $pesanan->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
        <p class="text-center fs-4 pt-5">Tidak ada riwayat pemesanan</p>
                @endif
                <div class="text-center">
                    <a href="{{ route('userr.menu') }}" class="btn btn-secondary mt-3">
                        <i class="fa fa-arrow-left"></i> Pesan sekarang !
                    </a>
                </div>
    </div>

    @include('layouts.footer')
