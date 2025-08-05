@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Mahasiswa</h4>
                        <p class="card-description">Form edit data mahasiswa</p>

                        <form class="forms-sample" action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}"
                            method="POST">
                            @csrf @method('PUT')

                            <div class="form-group">
                                <label for="nama">Nama Mahasiswa</label>
                                <input type="text" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $mahasiswa->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nim">NIM</label>
                                <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                    value="{{ old('nim', $mahasiswa->nim) }}" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="prodi">Program Studi</label>
                                <input type="text" name="prodi"
                                    class="form-control @error('prodi') is-invalid @enderror"
                                    value="{{ old('prodi', $mahasiswa->prodi) }}" required>
                                @error('prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email Mahasiswa</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $mahasiswa->user->email ?? '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-light">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
