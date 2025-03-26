@extends('layouts.main')
@include('layouts.navbar')
@section('title', 'Pengumuman')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }
    .mtitle {
        font-size: 2.5rem;
        font-weight: bold;
        text-align: center;
        margin-top: 50px;
        color: #343a40;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #343a40;
    }
    .card-text {
        font-size: 1rem;
        color: #6c757d;
    }
    .card-link {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }
    .card-link:hover {
        text-decoration: underline;
    }
    .text-muted {
        font-size: 0.875rem;
        color: #6c757d;
    }
    .no-announcement {
        font-size: 1.25rem;
        color: #6c757d;
        text-align: center;
        margin-top: 50px;
    }
</style>

<div class="container pt-5 my-5">
    <h2 class="mtitle">Pengumuman</h2>

    @if(isset($pengumumans) && count($pengumumans) > 0)
        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @foreach ($pengumumans as $pengumuman)
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $pengumuman->judul }}</h5>
                                <p class="card-text">{{ $pengumuman->teks }}</p>
                                @if ($pengumuman->tautan)
                                    <a href="{{ $pengumuman->tautan }}" target="_blank" class="card-link">
                                        Klik di sini
                                    </a>
                                @endif
                                <p class="card-text">
                                    <small class="text-muted">
                                        Dibuat pada {{ date('d-m-Y', strtotime($pengumuman->tanggal)) }}
                                    </small>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <p class="no-announcement">Pengumuman tidak tersedia</p>
    @endif
</div>

@include('layouts.footer')
