@extends('layouts.main')
@section('title', 'Create testimoni user ')

<div class="d-flex justify-content-center align-items-center vh-15">
    <img src="{{ asset('menu.png') }}" class="img-fluid" style="width:200px">
</div>
<br>
<div class="d-flex justify-content-center align-items-center vh-10">
    <h2 class="fw-semibold fs-4 text-center">Tambah Testimoni</h2>
</div>
<br>

<div class="mt-4">
    <div class="container">
        <div class="row align-items-center">

            <!-- Kolom Kiri: Formulir Deskripsi -->
            <div class="col-lg-6 d-flex flex-column gap-3">
                <form action="{{ route('testimoni.store') }}" method="POST" class="p-4 border rounded shadow w-100">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>⚠️ Periksa rating anda, pastikan semuanya terisi!</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5"></textarea>
                    </div>

                    <input type="hidden" name="rating" id="rating" value="0">

                    <button type="submit" class="btn btn-dark w-100">Simpan</button>
                    <a href="{{ route('testimoni.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                </form>
            </div>

            <!-- Kolom Kanan: Rating Bintang -->
            <div class="col-lg-6 d-flex justify-content-center">
                <div class="card shadow-lg p-3" style="max-width: 80%;">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Beri Rating</h5>
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="fa fa-star star" data-rating="{{ $i }}"></span>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Tambahkan CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .rating {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .star {
        font-size: 25px;
        cursor: pointer;
        color: black;
    }

    .star.active {
        color: gold;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.querySelector('#rating');
        const form = document.querySelector("form");

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const ratingValue = this.getAttribute('data-rating');

                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= ratingValue) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });

                ratingInput.value = ratingValue;
            });
        });


        form.addEventListener("submit", function(event) {
            if (ratingInput.value === "0") {
                alert("Silakan beri rating sebelum mengirim testimoni.");
                event.preventDefault();
            }
        });
    });
</script>
