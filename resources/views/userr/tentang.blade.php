@include('layouts.navbar')
@extends('layouts.main')
@section('title', 'Tentang DelCafe')


<style>
    /* Gradient untuk judul */
    .text-gradient {
        background: linear-gradient(90deg, #177ee4, #ff29e2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Efek hover pada card */
    .hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }
    .hover-effect:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    /* Background card dengan gradient */
    .card {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    /* Typografi modern dengan Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
    body {
        font-family: 'Poppins', sans-serif;
    }
    .card-title {
        font-weight: 700;
    }
    .card-text {
        font-weight: 400;
    }
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
        <h2 class="mtitle">Tentang DEL Cafe</h2>
        <br><br>

    <div class="row">
        @if (isset($tentangs) && count($tentangs) > 0)
            @foreach ($tentangs as $tentang)
                @php
                    // Acak ukuran kolom antara col-lg-4, col-lg-6, dan col-lg-8
                    $randomCol = ['col-lg-4', 'col-lg-6', 'col-lg-8'][array_rand(['col-lg-4', 'col-lg-6', 'col-lg-8'])];
                @endphp
                <div class="{{ $randomCol }} col-md-6 col-sm-12 mb-4">
                    <div class="card h-100 border-0 shadow-lg hover-effect">
                        <div class="card-body p-4">
                            <h1 class="card-title display-5 fw-bold mb-3 text-gradient">{{ $tentang->judul }}</h1>
                            <p class="card-text fs-5 text-secondary">
                                {{ $tentang->deskripsi }}
                            </p>
                            <small class="text-muted d-block text-end mt-3">Dibuat pada {{ date('d-m-Y', strtotime($tentang->tanggal)) }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p class="text-center fs-4">Tentang tidak tersedia</p>
            </div>
        @endif
    </div>
</div>

@include('layouts.footer')
