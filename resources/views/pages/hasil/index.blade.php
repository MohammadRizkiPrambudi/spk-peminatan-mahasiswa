@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Hasil Rekomendasi Semua Mahasiswa</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Prodi</th>
                                <th>Peminatan</th>
                                <th>Kepercayaan (%)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $i => $d)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $d->mahasiswa->nama }}</td>
                                    <td>{{ $d->mahasiswa->nim }}</td>
                                    <td>{{ $d->mahasiswa->prodi }}</td>
                                    <td><strong>{{ $d->peminatan_utama }}</strong></td>
                                    <td>{{ number_format($d->nilai_kepercayaan * 100, 2) }}%</td>
                                    <td>
                                        <a href="{{ route('admin.proses.index') }}" class="btn btn-sm btn-warning">Ulang</a>
                                        <button class="btn btn-sm btn-info btn-detail"
                                            data-id="{{ $d->mahasiswa_id }}">Detail</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada hasil rekomendasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Rekomendasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <p class="text-muted">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;

                fetch(`/admin/proses/ajax/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        let content = `
                        <p><strong>Nama:</strong> ${data.mahasiswa.nama}</p>
                        <p><strong>NIM:</strong> ${data.mahasiswa.nim}</p>
                        <p><strong>Prodi:</strong> ${data.mahasiswa.prodi}</p>

                        <h5 class="mt-3">Nilai Output Fuzzy BPA</h5>
                        <table class="table table-bordered">
                            <thead><tr><th>Bidang</th><th>Nilai BPA</th></tr></thead>
                            <tbody>
                                ${Object.entries(data.fuzzy).map(([k, v]) => `
                                                                <tr><td>${k}</td><td>${Number(v).toFixed(4)}</td></tr>
                                                            `).join('')}
                            </tbody>
                        </table>

                        <h5 class="mt-3">Output Dempster-Shafer (Gabungan)</h5>
                        <table class="table table-bordered">
                            <thead><tr><th>Bidang</th><th>Belief (Kepercayaan)</th></tr></thead>
                            <tbody>
                                ${Object.entries(data.ds).map(([k, v]) => `
                                                                <tr><td>${k}</td><td>${Number(v).toFixed(4)}</td></tr>
                                                            `).join('')}
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <h4 class="text-primary">Rekomendasi: <strong>${data.rekomendasi}</strong></h4>
                        </div>
                    `;

                        document.getElementById('modalContent').innerHTML = content;
                        new bootstrap.Modal(document.getElementById('detailModal')).show();
                    })
                    .catch(err => {
                        document.getElementById('modalContent').innerHTML =
                            `<p class="text-danger">Gagal memuat data.</p>`;
                    });
            });
        });
    </script>
@endpush
