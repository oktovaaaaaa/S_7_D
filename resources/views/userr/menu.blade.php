@extends('layouts.main')
@include('layouts.navbar')
@section('title', 'Menu')

<div class="container ">
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
        <h2 class="mtitle">Menu</h2>
        @if(isset($menus) && count($menus) > 0)

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @auth
        @if (auth()->user()->role == 'user' && auth()->user()->id)
        <div class="py-3">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 ">
                @foreach ($menus as $menu)
                <div class="col" data-menu-id="{{ $menu->id }}">
                    <div class="card h-100 shadow-sm rounded-4 overflow-hidden" style="max-width: 250px; margin: auto;">
                        <!-- Gambar dengan aspect ratio 1:1 -->
                        <div class="ratio ratio-1x1">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#menuModal{{ $menu->id }}">
                                <img src="{{ url('storage/images/' . $menu->foto) }}" class="card-img-top img-fluid rounded-top-4"
                                    alt="{{ $menu->nama }}" style="object-fit: cover; height: 220px;">
                            </a>
                        </div>
                        <div class="card-body d-flex flex-column" style="padding: 0.75rem;">
                            <h5 class="card-title mb-1" style="font-size: 1rem;">{{ $menu->nama }}</h5>
                            <p class="card-text mb-1" style="font-size: 0.8rem;">{{ $menu->deskripsi }}</p>
                            <p class="card-text fw-bold text-primary mb-2" style="font-size: 0.9rem;">Rp
                                {{ $menu->harga}}</p>
                            <form id="payment-form-{{ $menu->id }}" action="{{ route('userr.prosesPembayaran') }}" method="POST">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <div class="mb-1">
                                    <label for="jumlah" class="form-label" style="font-size: 0.8rem;">Jumlah</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary kurangCard" type="button"
                                            data-menu-id="{{ $menu->id }}"
                                            style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">-</button>
                                        <input type="number" name="jumlah" id="jumlahCard{{ $menu->id }}"
                                            class="form-control jumlah-input jumlahCard" value="1" min="1"
                                            style="font-size: 0.8rem; padding: 0.2rem;">
                                        <button class="btn btn-outline-secondary tambahCard" type="button"
                                            data-menu-id="{{ $menu->id }}"
                                            style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">+</button>
                                    </div>
                                </div>

                                <p style="font-size: 0.8rem;">Total Harga: <span id="totalHarga{{ $menu->id }}">Rp
                                        {{ $menu->harga }}</span></p>
                                <button id="pay-button-{{ $menu->id }}" type="submit" class="btn btn-primary"
                                    style="font-size: 0.8rem; padding: 0.3rem 0.6rem;">Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Menu -->
                <div class="modal fade" id="menuModal{{ $menu->id }}" tabindex="-1"
                    aria-labelledby="menuModalLabel{{ $menu->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="menuModalLabel{{ $menu->id }}">{{ $menu->nama }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" data-harga="{{ str_replace(['Rp', '.'], '', $menu->harga) }}">
                                <img src="{{ url('storage/images/' . $menu->foto) }}" class="img-fluid mb-2"
                                    alt="{{ $menu->nama }}">
                                <p style="font-size: 0.9rem;">{{ $menu->deskripsi }}</p>
                                <p class="fw-bold" style="font-size: 0.9rem;">Harga: Rp {{ $menu->harga }}</p>

                                <form action="{{ route('userr.tambahKeranjang', $menu->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-1">
                                        <label for="jumlah" class="form-label" style="font-size: 0.8rem;">Jumlah</label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary kurangModal" type="button"
                                                data-menu-id="{{ $menu->id }}"
                                                style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">-</button>
                                            <input type="number" name="jumlah" id="jumlahModal{{ $menu->id }}"
                                                class="form-control jumlah-input jumlahModal" value="1" min="1"
                                                style="font-size: 0.8rem; padding: 0.2rem;">
                                            <button class="btn btn-outline-secondary tambahModal" type="button"
                                                data-menu-id="{{ $menu->id }}"
                                                style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">+</button>
                                        </div>
                                    </div>
                                    <p style="font-size: 0.8rem;">Total Harga: <span
                                            id="totalHargaModal{{ $menu->id }}">Rp {{ $menu->harga }}</span></p>
                                    <button type="submit" class="btn btn-primary"
                                        style="font-size: 0.8rem; padding: 0.3rem 0.6rem;">Tambah ke Keranjang</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endauth
        @else
        <div class="py-3 pt-5 my-5">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 ">
                @foreach ($menus as $menu)
                <div class="col" data-menu-id="{{ $menu->id }}">
                    <div class="card h-100 shadow-sm rounded-4 overflow-hidden" style="max-width: 250px; margin: auto;">
                        <!-- Gambar dengan aspect ratio 1:1 -->
                        <div class="ratio ratio-1x1">
                            <img src="{{ url('storage/images/' . $menu->foto) }}" class="card-img-top img-fluid rounded-top-4"
                                alt="{{ $menu->nama }}" style="object-fit: cover; height: 220px; pointer-events: none;">
                        </div>
                        <div class="card-body d-flex flex-column" style="padding: 0.75rem;">
                            <h5 class="card-title mb-1" style="font-size: 1rem;">{{ $menu->nama }}</h5>
                            <p class="card-text mb-1" style="font-size: 0.8rem;">{{ $menu->deskripsi }}</p>
                            <p class="card-text fw-bold text-primary mb-2" style="font-size: 0.9rem;">Rp
                                {{ $menu->harga}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @auth
    @if (auth()->user()->role == 'admin')
    <div class="py-3 pt-5 my-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 ">
            @foreach ($menus as $menu)
            <div class="col" data-menu-id="{{ $menu->id }}">
                <div class="card h-100 shadow-sm rounded-4 overflow-hidden" style="max-width: 250px; margin: auto;">
                    <!-- Gambar dengan aspect ratio 1:1 -->
                    <div class="ratio ratio-1x1">
                        <img src="{{ url('storage/images/' . $menu->foto) }}" class="card-img-top img-fluid rounded-top-4"
                            alt="{{ $menu->nama }}" style="object-fit: cover; height: 220px; pointer-events: none;">
                    </div>
                    <div class="card-body d-flex flex-column" style="padding: 0.75rem;">
                        <h5 class="card-title mb-1" style="font-size: 1rem;">{{ $menu->nama }}</h5>
                        <p class="card-text mb-1" style="font-size: 0.8rem;">{{ $menu->deskripsi }}</p>
                        <p class="card-text fw-bold text-primary mb-2" style="font-size: 0.9rem;">Rp
                            {{ $menu->harga}}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <p class="text-center fs-4 pt-5">Menu tidak tersedia</p>
            @endif
        </div>
    </div>
    @endif
    @endauth
    @include('layouts.footer')

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi untuk update total harga
            function updateTotalHarga(menuId) {
                // Ambil elemen card
                const card = document.querySelector(`.col[data-menu-id="${menuId}"]`);

                //Ambil harga awal dari card
                const hargaAwal = card.querySelector('.card-text.fw-bold.text-primary').innerText;
                const hargaSatuan = parseFloat(hargaAwal.replace(/[^0-9]/g, ''));

                // Update Quantity card
                const jumlahCard = parseInt(card.querySelector(`#jumlahCard${menuId}`).value);
                const totalHargaCard = hargaSatuan * jumlahCard;

                // Update total harga di card
                card.querySelector(`#totalHarga${menuId}`).innerText = 'Rp ' + totalHargaCard.toLocaleString('id-ID');

                //Ambil harga dari modal
                const modalBody = document.querySelector(`#menuModal${menuId} .modal-body`);
                const hargaAwalModal = modalBody.dataset.harga;

                // Update Quantity Modal
                const jumlahModal = parseInt(modalBody.querySelector(`#jumlahModal${menuId}`).value);
                const totalHargaModal = hargaSatuan * jumlahModal;

                //Update total harga di modal
                modalBody.querySelector(`#totalHargaModal${menuId}`).innerText = 'Rp ' + totalHargaModal.toLocaleString('id-ID');

            }

            // Event listener untuk tombol tambah di card
            document.querySelectorAll('.tambahCard').forEach(button => {
                button.addEventListener('click', function () {
                    const menuId = this.dataset.menuId;
                    let jumlahInputCard = document.querySelector(`.col[data-menu-id="${menuId}"] #jumlahCard${menuId}`);
                    let jumlahInputModal = document.querySelector(`#menuModal${menuId} .modal-body #jumlahModal${menuId}`);

                    jumlahInputCard.value = parseInt(jumlahInputCard.value) + 1;
                    jumlahInputModal.value = parseInt(jumlahInputModal.value) + 1;

                    updateTotalHarga(menuId);
                });
            });

            // Event listener untuk tombol kurang di card
            document.querySelectorAll('.kurangCard').forEach(button => {
                button.addEventListener('click', function () {
                    const menuId = this.dataset.menuId;

                    let jumlahInputCard = document.querySelector(`.col[data-menu-id="${menuId}"] #jumlahCard${menuId}`);
                    let jumlahInputModal = document.querySelector(`#menuModal${menuId} .modal-body #jumlahModal${menuId}`);

                    let currentValue = parseInt(jumlahInputCard.value);
                    if (currentValue > 1) {
                        jumlahInputCard.value = currentValue - 1;
                        jumlahInputModal.value = currentValue - 1;
                        updateTotalHarga(menuId);
                    }
                });
            });

            // Event listener untuk tombol tambah di modal
            document.querySelectorAll('.tambahModal').forEach(button => {
                button.addEventListener('click', function () {
                    const menuId = this.dataset.menuId;
                    let jumlahInputCard = document.querySelector(`.col[data-menu-id="${menuId}"] #jumlahCard${menuId}`);
                    let jumlahInputModal = document.querySelector(`#menuModal${menuId} .modal-body #jumlahModal${menuId}`);

                    jumlahInputCard.value = parseInt(jumlahInputCard.value) + 1;
                    jumlahInputModal.value = parseInt(jumlahInputModal.value) + 1;
                    updateTotalHarga(menuId);
                });
            });

            // Event listener untuk tombol kurang di modal
            document.querySelectorAll('.kurangModal').forEach(button => {
                button.addEventListener('click', function () {
                    const menuId = this.dataset.menuId;
                    let jumlahInputCard = document.querySelector(`.col[data-menu-id="${menuId}"] #jumlahCard${menuId}`);
                    let jumlahInputModal = document.querySelector(`#menuModal${menuId} .modal-body #jumlahModal${menuId}`);
                    let currentValue = parseInt(jumlahInputModal.value);
                    if (currentValue > 1) {
                        jumlahInputCard.value = currentValue - 1;
                        jumlahInputModal.value = currentValue - 1;
                        updateTotalHarga(menuId);
                    }
                });
            });

            // Inisialisasi total harga saat modal ditampilkan
            const menuModals = document.querySelectorAll('.modal');
            menuModals.forEach(modal => {
                modal.addEventListener('shown.bs.modal', function () {
                    const menuId = this.id.replace('menuModal', '');
                    updateTotalHarga(menuId); // Panggil fungsi updateTotalHarga
                });
            });
        });

        // Untuk midtransCallback
        $(document).ready(function () {
            // Attach event listener to each payment form
            @foreach($menus as $menu)
            $('#payment-form-{{ $menu->id }}').submit(function (e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);

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
                        alert('Terjadi kesalahan: ' + error);
                        console.error(xhr.responseText);
                    }
                });
            });
            @endforeach
        });

    </script>
