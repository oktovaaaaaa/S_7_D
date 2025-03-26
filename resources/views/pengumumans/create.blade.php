@extends('layouts.main')
@section('title', 'Create pengumuman admin')

<div class="d-flex justify-content-center align-items-center vh-15">
    <img src="{{asset('pengumuman.png')}}" class="img-fluid" style="width:200px">
</div>
<br>
<div class="d-flex justify-content-center align-items-center vh-10">
    <h2 class="fw-semibold fs-4 text-center">Tambah pengunguman</h2>
</div>
<br>
</div>


<div class="mt-4" x-data="{imageUrl: '/storage/noimage.png'}">
<div class="container">
    <div class="row align-items-center">

        <div class="col-lg-12 d-flex flex-column gap-3">
            <form enctype="multipart/form-data" method="POST" action="{{ route('pengumumans.store') }}" class="p-4 border rounded shadow w-100">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input id="judul" class="form-control" type="text" name="judul" value="{{ old('judul') }}" required/>
                </div>

                <div class="mb-3">
                    <label for="teks" class="form-label">teks</label>
                    <textarea id="teks" class="form-control" name="teks" rows="3">{{ old('teks') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="tautan" class="form-label">tautan</label>
                    <input id="tautan" class="form-control" type="text" name="tautan" value="{{ old('tautan') }}"/>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal (Tanggal-Bulan-Tahun)</label>
                    <input id="tanggal" class="form-control" type="date" name="tanggal" value="{{ old('tanggal') }}" required/>
                </div>




                <button type="submit" class="btn btn-dark w-100">Submit</button>
            </form>
        </div>


