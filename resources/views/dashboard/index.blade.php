@extends('layouts.main')

@section('content')
    @role('admin')
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin mb-4">
                    <h3 class="font-weight-bold">Dashboard Admin</h3>
                    <h6 class="font-weight-normal mb-0">Selamat datang di Sistem Pendukung Keputusan Peminatan Mahasiswa TI</h6>
                </div>
            </div>

            {{-- Statistik utama --}}
            <div class="row">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <p class="mb-2">Jumlah Mahasiswa</p>
                            <h4 class="font-weight-bold">{{ $jumlahMahasiswa }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <p class="mb-2">Nilai Akademik</p>
                            <h4 class="font-weight-bold">{{ $jumlahNilai }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <p class="mb-2">Preferensi Minat</p>
                            <h4 class="font-weight-bold">{{ $jumlahPreferensi }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <p class="mb-2">Tes Bakat</p>
                            <h4 class="font-weight-bold">{{ $jumlahTesBakat }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistik hasil rekomendasi --}}
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Distribusi Hasil Rekomendasi</h4>
                            <canvas id="peminatanChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Statistik Pengguna Sistem</h4>
                            <ul class="list-arrow">
                                <li>Admin: {{ $jumlahAdmin }}</li>
                                <li>Mahasiswa: {{ $jumlahMahasiswa }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
    @role('mahasiswa')
        <div class="content-wrapper">
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="font-weight-bold">Dashboard Mahasiswa</h3>
                    <h6 class="font-weight-normal mb-0">Selamat datang {{ Auth::user()->name }}! di Sistem Pendukung Keputusan
                        Peminatan Mahasiswa TI</h6>
                </div>
            </div>

            <div class="row">
                <!-- Preferensi Minat -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <p class="mb-2">Preferensi Minat</p>
                            <h4 class="font-weight-bold">{{ $jumlahPreferensi }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Hasil Rekomendasi -->
                <div class="col-md-6 stretch-card grid-margin">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <p class="mb-2">Rekomendasi Peminatan</p>
                            @if ($hasilRekomendasi)
                                <h4 class="font-weight-bold">{{ $hasilRekomendasi->peminatan_utama }}</h4>
                                <small>Nilai Keyakinan:
                                    {{ number_format($hasilRekomendasi->nilai_kepercayaan * 100) }}%</small>
                            @else
                                <p class="text-white">Belum tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <!-- Nilai Akademik -->
            <div class="row">
                <div class="col-md-6 stretch-card grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Nilai Akademik</h4>
                            @if ($nilaiAkademik->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Mata Kuliah</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nilaiAkademik as $nilai)
                                                <tr>
                                                    <td>{{ $nilai->matakuliah }}</td>
                                                    <td>{{ $nilai->nilai }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Belum ada data nilai.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Nilai Tes bakat</h4>
                            @if ($tesBakat->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Bidang</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tesBakat as $tes)
                                                <tr>
                                                    <td>{{ $tes->kategori_bakat }}</td>
                                                    <td>{{ $tes->skor }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Belum ada data nilai.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole()
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('peminatanChart').getContext('2d');
        const peminatanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData->keys()) !!},
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: {!! json_encode($chartData->values()) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
@endpush
