@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Tambah Nilai Mahasiswa</h4>
                        <p class="card-description">Form input data nilai mahasiswa</p>

                        <form action="{{ route('admin.nilai.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Mahasiswa</label>
                                <select name="mahasiswa_id" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($mahasiswa as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama }} ({{ $m->nim }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Mata Kuliah</label>
                                <select name="matakuliah" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($matakuliah as $mk)
                                        <option value="{{ $mk }}">{{ $mk }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nilai</label>
                                <input type="number" name="nilai" class="form-control" required min="0"
                                    max="100">
                            </div>

                            <button class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.nilai.index') }}" class="btn btn-light">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
