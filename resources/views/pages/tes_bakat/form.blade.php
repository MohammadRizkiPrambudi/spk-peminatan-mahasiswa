@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Tes Bakat</h4>
                <p class="card-description">Masukkan skor tes bakat untuk masing-masing bidang</p>

                <form action="{{ route('tes.submit') }}" method="POST" class="forms-sample">
                    @csrf

                    @foreach ($bidangBakat as $bidang)
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ $bidang }}</label>
                            <div class="col-sm-9">
                                <input type="number" name="skor[{{ $bidang }}]" min="0" max="100"
                                    class="form-control @error('skor.' . $bidang) is-invalid @enderror"
                                    value="{{ old('skor.' . $bidang, $existing[$bidang] ?? '') }}" required>
                                @error('skor.' . $bidang)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
