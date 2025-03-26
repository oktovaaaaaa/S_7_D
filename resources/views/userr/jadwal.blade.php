@extends('layouts.main')
@include('layouts.navbar')
@section('title', 'Jadwal')

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
        <h2 class="mtitle">Jadwal</h2>

    @if(isset($jadwals) && count($jadwals) > 0)
            <br>
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th scope="col" class="text-center">Hari</th>
                    <th scope="col" class="text-center">Waktu Mulai</th>
                    <th scope="col" class="text-center">Waktu Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwals as $jadwal)
                    <tr>
                        <td class="text-center">{{ $jadwal->hari }}</td>
                        <td class="text-center">{{ $jadwal->waktu_mulai }}</td>
                        <td class="text-center">{{ $jadwal->waktu_selesai }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center fs-4 pt-5">Jadwal tidak tersedia</p>
    @endif
    </div>


@include('layouts.footer')
</div>
