@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Preferensi Minat</h4>
                        <p class="card-description">Form input data preferensi minat</p>

                        <form action="{{ route('admin.minat.store') }}" method="POST">
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
                                <label>Bidang</label>
                                <select name="bidang" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($bidang as $b)
                                        <option value="{{ $b }}">{{ $b }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tingkat Minat</label>
                                <select name="tingkat_minat" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($tingkat as $t)
                                        <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.minat.index') }}" class="btn btn-light">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
