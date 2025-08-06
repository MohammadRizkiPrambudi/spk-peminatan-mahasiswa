@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Preferensi Minat</h4>
                        <p class="card-description">Form edit data preferensi minat</p>

                        <form action="{{ route('admin.minat.update', $minat->id) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="form-group">
                                <label>Mahasiswa</label>
                                <select name="mahasiswa_id" class="form-control" required>
                                    @foreach ($mahasiswa as $m)
                                        <option value="{{ $m->id }}"
                                            {{ $minat->mahasiswa_id == $m->id ? 'selected' : '' }}>
                                            {{ $m->nama }} ({{ $m->nim }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Bidang</label>
                                <select name="bidang" class="form-control" required>
                                    @foreach ($bidang as $b)
                                        <option value="{{ $b }}" {{ $minat->bidang == $b ? 'selected' : '' }}>
                                            {{ $b }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tingkat Minat</label>
                                <select name="tingkat_minat" class="form-control" required>
                                    @foreach ($tingkat as $t)
                                        <option value="{{ $t }}"
                                            {{ $minat->tingkat_minat == $t ? 'selected' : '' }}>
                                            {{ ucfirst($t) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.minat.index') }}" class="btn btn-light">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
