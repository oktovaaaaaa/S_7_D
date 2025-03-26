@extends('layouts.main')
@include('layouts.navbar')
@section('title', 'Keranjang')

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
    <h2 class="mtitle">Keranjang</h2>
    <br>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(count($keranjangItems) > 0)
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nama Menu</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga Satuan</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjangItems as $item)
                <tr>
                    <td>{{ $item->menu->nama }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ $item->menu->harga }}</td>
                    <!-- Harga satuan tanpa format -->
                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.')}}</td>
                    <!-- Total harga tanpa format -->
                    <td>
                        <form action="{{ route('userr.hapusKeranjang', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <h4 class="mb-0">Total Belanja: Rp {{ number_format($keranjangItems->sum('total_harga'), 0, ',', '.') }}</h4>
        <!-- Total belanja tanpa format -->
        <form id="payment-form" action="{{ route('userr.prosesPembayaranKeranjang') }}" method="POST">
            @csrf
            <button id="pay-button" type="submit" class="btn btn-success btn-lg">Bayar Sekarang</button>
        </form>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('userr.menu') }}" class="btn btn-outline-secondary">Kembali ke Menu</a>
    </div>
    @else
    <div class="text-center py-5">
        <h3 class="text-muted">Keranjang Anda masih kosong.</h3>
        <a href="{{ route('userr.menu') }}" class="btn btn-secondary mt-3">Mulai Belanja</a>
    </div>
    @endif

</div>

@include('layouts.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    $(document).ready(function () {
        $('#payment-form').submit(function (e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log('AJAX success', response);

                    snap.pay(response.snapToken, {
                        onSuccess: function (result) {
                            window.location.href = '/userr/riwayatPesanan';
                        },
                        onPending: function (result) {
                            alert('Menunggu pembayaran!');
                            console.log(result);
                        },
                        onError: function (error) {
                            alert('Pembayaran gagal!');
                            console.log(error);
                        },
                        onClose: function () {
                            alert('Anda menutup jendela pembayaran sebelum menyelesaikan pembayaran');
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.log('AJAX error', xhr, status, error);

                    // Jika response dari server adalah JSON
                    if (xhr.responseJSON) {
                        // Periksa apakah ada pesan error di JSON
                        if (xhr.responseJSON.error) {
                            alert('Terjadi kesalahan: ' + xhr.responseJSON.error); // Tampilkan pesan error dari server
                        } else {
                            // Tampilkan seluruh response JSON
                            alert('Terjadi kesalahan: ' + JSON.stringify(xhr.responseJSON));
                        }
                    }
                    // Jika response bukan JSON
                    else {
                        // Tampilkan informasi detail tentang error
                        alert('Terjadi kesalahan: ' + status + ' - ' + error + ' - ' + xhr.responseText);
                        console.error(xhr.responseText);
                    }
                }
            });
        });
    });
</script>
