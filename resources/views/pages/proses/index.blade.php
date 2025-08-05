@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Proses Rekomendasi Peminatan</h4>
                <p class="mb-4">Klik tombol "Proses" untuk menjalankan perhitungan rekomendasi terhadap mahasiswa.</p>

                <div class="table-responsive">
                    <table class="table table-hover" id="myDataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswa as $index => $m)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $m->nama }}</td>
                                    <td>{{ $m->nim }}</td>
                                    <td>{{ $m->prodi }}</td>
                                    <td>
                                        <a href="{{ route('admin.proses.proses', $m->id) }}" class="btn btn-success">
                                            <i class="ti-reload"></i> Proses
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($mahasiswa->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data mahasiswa.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
