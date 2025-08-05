@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Hasil Rekomendasi Peminatan</h4>
                <div class="mb-3">
                    <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
                    <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
                    <p><strong>Prodi:</strong> {{ $mahasiswa->prodi }}</p>
                </div>

                <h5 class="mt-4">Nilai Output Fuzzy BPA</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bidang</th>
                                <th>Nilai BPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fuzzyResult as $k => $v)
                                <tr>
                                    <td>{{ ucfirst($k) }}</td>
                                    <td>{{ number_format($v, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h5 class="mt-4">Output Dempster-Shafer (Gabungan)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bidang</th>
                                <th>Belief (Kepercayaan)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dsResult as $k => $v)
                                <tr>
                                    <td>{{ ucfirst($k) }}</td>
                                    <td>{{ number_format($v, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h4 class="text-success">Rekomendasi Peminatan: <strong>{{ $rekomendasi }}</strong></h4>
                </div>

                <a href="{{ route('admin.proses.index') }}" class="btn btn-secondary mt-3">Kembali ke Proses</a>
            </div>
        </div>
    </div>
@endsection
