@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Tes Bakat</h4>
                        <p class="card-description">Form edit data tes bakat</p>

                        <form action="{{ route('admin.tes.update', $tes->id) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="form-group">
                                <label>Mahasiswa</label>
                                <select name="mahasiswa_id" class="form-control" required>
                                    @foreach ($mahasiswa as $m)
                                        <option value="{{ $m->id }}"
                                            {{ $tes->mahasiswa_id == $m->id ? 'selected' : '' }}>
                                            {{ $m->nama }} ({{ $m->nim }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="kategori_bakat" class="form-control" required>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k }}"
                                            {{ $tes->kategori_bakat == $k ? 'selected' : '' }}>
                                            {{ $k }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Skor</label>
                                <input type="number" name="skor" class="form-control" value="{{ $tes->skor }}"
                                    min="0" max="100" required>
                            </div>

                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.tes.index') }}" class="btn btn-light">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
