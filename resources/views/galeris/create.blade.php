@extends('layouts.main')
@section('title', 'Create galeri admin')

<div class="d-flex justify-content-center align-items-center vh-15">
    <img src="{{asset('galeri.png')}}" class="img-fluid" style="width:200px">
</div>
<br>
<div class="d-flex justify-content-center align-items-center vh-10">
    <h2 class="fw-semibold fs-4 text-center">Tambah galeri</h2>
</div>
<br>
</div>


<div class="mt-4" x-data="{imageUrl: '/storage/noimage.png'}">
<div class="container">
    <div class="row align-items-center">

        <div class="col-lg-6 d-flex flex-column gap-3">
            <form enctype="multipart/form-data" method="POST" action="{{ route('galeris.store') }}" class="p-4 border rounded shadow w-100">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input id="nama" class="form-control" type="text" name="nama" value="{{ old('nama') }}" required/>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" class="form-control" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input accept="image/*" id="foto" class="form-control" type="file" name="foto" required
                        onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                </div>

                <button type="submit" class="btn btn-dark w-100">Submit</button>
            </form>
        </div>

        <div class="col-lg-6 d-flex justify-content-center">
            <div class="card shadow-lg p-3" style="max-width: 80%;">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Gambar Product</h5>
                    <img id="preview" class="rounded-md img-fluid" style="max-width: 100%;" src="{{ url('storage/noimage.png') }}">
                </div>
            </div>
        </div>

