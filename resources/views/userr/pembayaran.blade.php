@extends('layouts.main')
@include('layouts.navbar')
@section('title', 'Pembayaran')

<div class="container">
    <h1>Halaman Pembayaran</h1>
    <p>Total yang harus dibayar: Rp {{ number_format($total_harga, 0, ',', '.') }}</p>

    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>

</div>
@include('layouts.footer')

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();

        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = '/userr/riwayatPesanan'; // Redirect setelah sukses
            },
            onPending: function(result) {
                alert('Menunggu pembayaran!');
                console.log(result);
            },
            onError: function(error) {
                alert('Pembayaran gagal!');
                console.log(error);
            },
            onClose: function() {
                alert('Anda menutup jendela pembayaran sebelum menyelesaikan pembayaran');
            }
        });
    });
</script>
