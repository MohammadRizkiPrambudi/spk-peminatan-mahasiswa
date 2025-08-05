@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Tes Bakat</h4>
                        <p class="card-description">Form input data tes bakat</p>

                        <form action="{{ route('admin.tes.store') }}" method="POST">
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
                                <label>Kategori</label>
                                <select name="kategori_bakat" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k }}">{{ $k }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Skor</label>
                                <input type="number" name="skor" class="form-control" min="0" max="100"
                                    required>
                            </div>

                            <button class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.tes.index') }}" class="btn btn-light">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
