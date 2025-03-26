@extends('layouts.main')
@include('layouts.navbar')
@section('title', 'Kontak')

<section id="contact" class="contact section bg-light pt-5 my-5">
    <div class="container section-title" data-aos="fade-up">
        <h2>Kontak</h2>
        <p>Hubungi Kami Disini</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-lg-5 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4">Kontak Kami</h3>

                            <div class="info-item d-flex align-items-center mb-4" data-aos="fade-up"
                                data-aos-delay="200">
                                <i class="bi bi-geo-alt fs-4 me-3"></i>
                                <div>
                                    <h4 class="mb-1">Alamat</h4>
                                    <p class="mb-0">Sitoluama, Kec. Balige, Toba, Sumatera Utara 22381</p>
                                </div>
                            </div>

                            <div class="info-item d-flex align-items-center mb-4" data-aos="fade-up"
                                data-aos-delay="300">
                                <i class="bi bi-telephone fs-4 me-3"></i>
                                <div>
                                    <h4 class="mb-1">Hubungi Kami</h4>
                                    <p class="mb-0">+62 8810 8081 1110</p>
                                </div>
                            </div>

                            <div class="info-item d-flex align-items-center mb-4" data-aos="fade-up"
                                data-aos-delay="400">
                                <i class="bi bi-envelope fs-4 me-3"></i>
                                <div>
                                    <h4 class="mb-1">Email Kami</h4>
                                    <p class="mb-0">delcafe@gmail.com</p>
                                </div>
                            </div>

                            <div class="ratio ratio-16x9 mt-4">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14454.709428680257!2d99.15577820991412!3d2.3787195644477372!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e00fdad2d7341%3A0xf59ef99c591fe451!2sInstitut%20Teknologi%20Del!5e0!3m2!1sid!2sid!4v1741921101704!5m2!1sid!2sid"
                                    allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                @guest

                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">

                                <!-- Alert untuk notifikasi -->
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('kontakuserr') }}" method="post" class="needs-validation" novalidate
                                    data-aos="fade-up" data-aos-delay="200">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control" id="nama"
                                                value="{{ old('nama') }}" required>
                                            <div class="invalid-feedback">
                                                Harap isi nama Anda.
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="{{ old('email') }}" required>
                                            <div class="invalid-feedback">
                                                Harap isi email yang valid.
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="subjek" class="form-label">Subjek</label>
                                            <input type="text" class="form-control" name="subjek" id="subjek"
                                                value="{{ old('subjek') }}" required>
                                            <div class="invalid-feedback">
                                                Harap isi subjek pesan.
                                            </div>
                                        </div>

                                        <div class="col-12 pt-3">
                                            <label for="pesan" class="form-label">Pesan</label>
                                            <textarea class="form-control" name="pesan" rows="5" id="pesan" required>{{ old('pesan') }}</textarea>
                                            <div class="invalid-feedback">
                                                Harap isi pesan Anda.
                                            </div>
                                        </div>

                                        <div class="col-12 text-center pt-5 my-5">
                                            <button type="submit" class="btn rounded-pill py-2 px-4"
                                                style="background-color: #87CEEB; color: white; border: none;">Kirim
                                                Pesan</button>
                                        </div>
                                    </div>
                                </form>
                            @endguest
                            @auth
                                @if (auth()->user()->role == 'user')

                                    <div class="col-lg-7">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-4">

                                                <!-- Alert untuk notifikasi -->
                                                @if (session('success'))
                                                    <div class="alert alert-success alert-dismissible fade show"
                                                        role="alert">
                                                        {{ session('success') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                @if (session('error'))
                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                        role="alert">
                                                        {{ session('error') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                @if ($errors->any())
                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                        role="alert">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                <form action="{{ route('kontakuserr') }}" method="post"
                                                    class="needs-validation" novalidate data-aos="fade-up"
                                                    data-aos-delay="200">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label for="nama" class="form-label">Nama</label>
                                                            <input type="text" name="nama" class="form-control"
                                                                id="nama" value="{{ old('nama') }}" required>
                                                            <div class="invalid-feedback">
                                                                Harap isi nama Anda.
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email"
                                                                id="email" value="{{ old('email') }}" required>
                                                            <div class="invalid-feedback">
                                                                Harap isi email yang valid.
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="subjek" class="form-label">Subjek</label>
                                                            <input type="text" class="form-control" name="subjek"
                                                                id="subjek" value="{{ old('subjek') }}" required>
                                                            <div class="invalid-feedback">
                                                                Harap isi subjek pesan.
                                                            </div>
                                                        </div>

                                                        <div class="col-12 pt-3">
                                                            <label for="pesan" class="form-label">Pesan</label>
                                                            <textarea class="form-control" name="pesan" rows="5" id="pesan" required>{{ old('pesan') }}</textarea>
                                                            <div class="invalid-feedback">
                                                                Harap isi pesan Anda.
                                                            </div>
                                                        </div>

                                                        <div class="col-12 text-center pt-5 my-5">
                                                            <button type="submit" class="btn rounded-pill py-2 px-4"
                                                                style="background-color: #87CEEB; color: white; border: none;">Kirim
                                                                Pesan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                @endif
                            @endauth
                            @auth
                                @if (auth()->user()->role == 'admin')

                                    <div class="col-lg-7">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-4">

                                                <!-- Alert untuk notifikasi -->
                                                @if (session('success'))
                                                    <div class="alert alert-success alert-dismissible fade show"
                                                        role="alert">
                                                        {{ session('success') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                @if (session('error'))
                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                        role="alert">
                                                        {{ session('error') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                @if ($errors->any())
                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                        role="alert">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                <form action="{{ route('kontakuserr') }}" method="post"
                                                    class="needs-validation" novalidate data-aos="fade-up"
                                                    data-aos-delay="200">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label for="nama" class="form-label">Nama</label>
                                                            <input type="text" name="nama" class="form-control"
                                                                id="nama" value="{{ old('nama') }}" required>
                                                            <div class="invalid-feedback">
                                                                Harap isi nama Anda.
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email"
                                                                id="email" value="{{ old('email') }}" required>
                                                            <div class="invalid-feedback">
                                                                Harap isi email yang valid.
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="subjek" class="form-label">Subjek</label>
                                                            <input type="text" class="form-control" name="subjek"
                                                                id="subjek" value="{{ old('subjek') }}" required>
                                                            <div class="invalid-feedback">
                                                                Harap isi subjek pesan.
                                                            </div>
                                                        </div>

                                                        <div class="col-12 pt-3">
                                                            <label for="pesan" class="form-label">Pesan</label>
                                                            <textarea class="form-control" name="pesan" rows="5" id="pesan" required>{{ old('pesan') }}</textarea>
                                                            <div class="invalid-feedback">
                                                                Harap isi pesan Anda.
                                                            </div>
                                                        </div>


                                                    </div>
                                                </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

@include('layouts.footer')
