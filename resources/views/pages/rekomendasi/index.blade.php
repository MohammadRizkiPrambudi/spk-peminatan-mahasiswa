@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Hasil Rekomendasi Peminatan Mahasiswa</h4>

                <h5 class="mt-4">Output BPA Akademik:</h5>
                @if (!empty($bpaAkademikView))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bidang</th>
                                <th>Nilai BPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bpaAkademikView as $k => $v)
                                <tr>
                                    <td>{{ ucfirst($k) }}</td>
                                    <td>{{ number_format($v, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-danger">Data BPA Akademik belum tersedia.</p>
                @endif

                <h5 class="mt-4">Output BPA Tes Bakat:</h5>
                @if (!empty($bpaTesBakatView))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bidang</th>
                                <th>Nilai BPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bpaTesBakatView as $k => $v)
                                <tr>
                                    <td>{{ ucfirst($k) }}</td>
                                    <td>{{ number_format($v, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-danger">Data BPA Tes Bakat belum tersedia.</p>
                @endif

                <h5 class="mt-4">Output Dempster-Shafer (Gabungan):</h5>
                @if (!empty($dsResultView))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bidang</th>
                                <th>Kepercayaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan collect() dan sortDesc() untuk mengurutkan berdasarkan nilai --}}
                            @foreach (collect($dsResultView)->sortDesc() as $k => $v)
                                <tr>
                                    <td>{{ ucfirst($k) }}</td>
                                    <td>{{ number_format($v * 100) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-danger">Belum ada hasil Dempster-Shafer untuk mahasiswa ini.</p>
                @endif

                <div class="mt-4">
                    @if ($rekomendasi && $rekomendasi->peminatan_utama)
                        <h4 class="text-success">
                            Rekomendasi Peminatan Utama: <strong>{{ $rekomendasi->peminatan_utama }}</strong>
                        </h4>
                        <p>
                            Nilai Kepercayaan Rekomendasi:
                            <strong>{{ number_format($rekomendasi->nilai_kepercayaan * 100) }}%</strong>
                        </p>
                    @else
                        <h4 class="text-danger">
                            Belum ada hasil rekomendasi utama untuk mahasiswa ini.
                        </h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
