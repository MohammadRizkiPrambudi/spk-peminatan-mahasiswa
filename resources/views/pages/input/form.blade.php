@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Input Nilai & Minat</h4>
                        <p class="card-description">Isi nilai akademik dan preferensi minatmu</p>

                        <form class="forms-sample" action="{{ route('input.submit') }}" method="POST">
                            @csrf

                            <h5 class="mb-3">Nilai Akademik</h5>
                            @foreach ($matakuliah as $mk)
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ $mk }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="nilai[{{ $mk }}]" class="form-control"
                                            min="0" max="100"
                                            value="{{ old('nilai.' . $mk, $nilaiLama[$mk] ?? '') }}" required>

                                    </div>
                                </div>
                            @endforeach

                            <h5 class="mb-3 mt-4">Preferensi Minat</h5>
                            @foreach ($minat as $bidang)
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ $bidang }}</label>
                                    <div class="col-sm-8">
                                        <select name="minat[{{ $bidang }}]" class="form-control" required>
                                            <option value="">-- Pilih Tingkat Minat --</option>
                                            @foreach ($tingkat as $t)
                                                <option value="{{ $t }}"
                                                    {{ old('minat.' . $bidang, $minatLama[$bidang] ?? '') == $t ? 'selected' : '' }}>
                                                    {{ ucfirst($t) }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ url()->previous() }}" class="btn btn-light">Batal</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
