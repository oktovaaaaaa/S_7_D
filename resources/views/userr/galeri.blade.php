@include('layouts.navbar')
@extends('layouts.main')
@section('title', 'Galeri')

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
}

.mtitle {
    font-size: 2.5rem; /* Ukuran lebih besar untuk judul */
    font-weight: bold;
    text-align: center;
    margin-top: 40px; /* Mengurangi margin atas sedikit */
    margin-bottom: 30px; /* Menambahkan margin bawah untuk ruang */
    color: #343a40; /* Warna teks yang lebih gelap */
}

.card {
    border: none;
    border-radius: 15px; /* Sudut membulat */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Efek bayangan halus */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden; /* Memastikan gambar tidak melampaui batas */
}

.card:hover {
    transform: translateY(-8px); /* Efek melayang lebih halus */
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15); /* Bayangan lebih besar saat dihover */
}

.card-img-container {
    height: 220px; /* Tinggi yang tetap untuk gambar */
    overflow: hidden; /* Memotong gambar yang terlalu besar */
    border-radius: 15px 15px 0 0; /* Pembulatan sudut atas */
}

.card-img-top {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Memastikan gambar mengisi wadah tanpa distorsi */
    transition: transform 0.3s ease; /* Transisi halus saat dihover */
}

.card:hover .card-img-top {
    transform: scale(1.05); /* Efek zoom halus saat dihover */
}

.card-body {
    padding: 1.5rem; /* Padding lebih besar */
    text-align: center;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #343a40;
}

.card-text {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 0; /* Menghapus margin bawah default */
}

/* Styling Modal */
.modal-content {
    border-radius: 15px;
}

.modal-header {
    border-bottom: none;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    border-top: none;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

/* Carousel Styling */
.carousel-control-prev,
.carousel-control-next {
    width: auto; /* Lebar otomatis agar tidak terlalu lebar */
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.3); /* Latar belakang ikon yang lebih jelas */
    border-radius: 50%; /* Bentuk lingkaran */
    padding: 10px; /* Padding agar ikon lebih besar */
}
</style>

<div class="container pt-5 my-5">
    <h2 class="mtitle">Galeri DEL Cafe</h2>
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner pt-4">
            @if(isset($galeris) && count($galeris) > 0)
                @php
                $galerisPerSlide = 3;
                $galeriChunks = array_chunk($galeris->all(), $galerisPerSlide);
                @endphp

                @foreach ($galeriChunks as $key => $galeriChunk)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="d-flex flex-wrap justify-content-center gap-4">
                            @foreach ($galeriChunk as $galeri)
                                <div class="card col-lg-4" style="width: 22rem;" data-bs-toggle="modal" data-bs-target="#galeriModal{{ $galeri->id }}">
                                    <div class="card-img-container">
                                        <img src="{{ url('storage/images/' . $galeri->foto) }}" class="card-img-top" alt="{{ $galeri->nama }}">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $galeri->nama }}</h5>
                                        <p class="card-text">{{ $galeri->deskripsi }}</p>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="galeriModal{{ $galeri->id }}" tabindex="-1" aria-labelledby="galeriModalLabel{{ $galeri->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="galeriModalLabel{{ $galeri->id }}">{{ $galeri->nama }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="{{ url('storage/images/' . $galeri->foto) }}" class="img-fluid w-100" alt="{{ $galeri->nama }}" style="border-radius: 10%;">
                                                <p class="mt-3">{{ $galeri->deskripsi }}</p>
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
                @endforeach
            @else
                <div class="carousel-item active">
                    <p class="text-center fs-4">galeri tidak tersedia</p>
                </div>
            @endif
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@include('layouts.footer')
