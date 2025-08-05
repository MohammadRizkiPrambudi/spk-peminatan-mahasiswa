@extends('layouts.main') {{-- Memastikan halaman ini menggunakan layout utama Anda --}}

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12">
                        <h3 class="font-weight-bold">Profil Pengguna</h3>
                        <p class="font-weight-normal mb-0">Kelola informasi profil dan kata sandi Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Informasi Profil</h4>
                        <p class="card-description">
                            Perbarui informasi profil dan alamat email akun Anda.
                        </p>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Perbarui Kata Sandi</h4>
                        <p class="card-description">
                            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
                        </p>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Hapus Akun</h4>
                        <p class="card-description">
                            Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum
                            menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.
                        </p>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
