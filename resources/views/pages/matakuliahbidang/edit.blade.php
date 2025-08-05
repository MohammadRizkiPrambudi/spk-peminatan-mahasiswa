@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Relasi Matakuliah dan Bidang</h4>
                <form action="{{ route('admin.matakuliah-bidang.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="matakuliah">Nama Matakuliah</label>
                        <select name="matakuliah" id="matakuliah" class="form-control" required>
                            <option value="">-- Pilih Matakuliah --</option>
                            @foreach ($matakuliah as $mk)
                                <option value="{{ $mk }}" {{ $data->matakuliah == $mk ? 'selected' : '' }}>
                                    {{ $mk }}</option>
                            @endforeach
                        </select>
                        @error('matakuliah')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="bidang">Bidang Minat</label>
                        <select name="bidang" id="bidang" class="form-control" required>
                            <option value="">-- Pilih Bidang --</option>
                            @foreach ($bidang as $bidang)
                                <option value="{{ $bidang }}" {{ $data->bidang == $bidang ? 'selected' : '' }}>
                                    {{ $bidang }}</option>
                            @endforeach
                        </select>
                        @error('bidang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="bobot">Bobot Kontribusi (0 - 1)</label>
                        <input type="number" step="0.01" min="0" max="1" name="bobot"
                            class="form-control @error('bobot') is-invalid @enderror"
                            value="{{ old('bobot', $data->bobot) }}" required>
                        @error('bobot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.matakuliah-bidang.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
