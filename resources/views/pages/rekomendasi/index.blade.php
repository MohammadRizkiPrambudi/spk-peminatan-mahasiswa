@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Hasil Rekomendasi Peminatan</h4>

                <h5 class="mt-4">Output Fuzzy BPA:</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bidang</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fuzzy->output_fuzzy as $k => $v)
                            <tr>
                                <td>{{ ucfirst($k) }}</td>
                                <td>
                                    @if (is_array($v))
                                        @foreach ($v as $label => $val)
                                            {{ ucfirst($label) }}: {{ number_format($val, 4) }}<br>
                                        @endforeach
                                    @else
                                        {{ number_format($v, 4) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="mt-4">Output Dempster-Shafer:</h5>
                @if ($ds && $ds->belief)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bidang</th>
                                <th>Kepercayaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ds->belief as $k => $v)
                                <tr>
                                    <td>{{ ucfirst($k) }}</td>
                                    <td>{{ number_format($v, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-danger">Belum ada hasil Dempster-Shafer untuk mahasiswa ini.</p>
                @endif

                <div class="mt-4">
                    @if ($rekomendasi)
                        <h4 class="text-success">
                            Rekomendasi: <strong>{{ $rekomendasi->peminatan_utama }}</strong>
                        </h4>
                    @else
                        <h4 class="text-danger">
                            Belum ada hasil rekomendasi untuk mahasiswa ini.
                        </h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
