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
                                <th>Kepercayaan</th> {{-- Menghapus (%) --}}
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
                                    <td>{{ number_format($d->nilai_kepercayaan * 100) }}%</td> {{-- Menampilkan 4 desimal --}}
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
        // Pastikan DOM sudah sepenuhnya dimuat sebelum menjalankan script
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded. Attaching event listeners.');

            document.querySelectorAll('.btn-detail').forEach(button => {
                console.log('Found detail button:', button); // Log setiap tombol yang ditemukan
                button.addEventListener('click', function() {
                    console.log('Detail button clicked for ID:', this.dataset
                        .id); // Log saat tombol diklik
                    const id = this.dataset.id;

                    // Reset modal content
                    document.getElementById('modalContent').innerHTML =
                        '<p class="text-muted">Memuat data...</p>';

                    fetch(`/admin/proses/ajax/${id}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response
                                    .statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Data received:', data); // Log data yang diterima
                            let content = `
                                <p><strong>Nama:</strong> ${data.mahasiswa.nama}</p>
                                <p><strong>NIM:</strong> ${data.mahasiswa.nim}</p>
                                <p><strong>Prodi:</strong> ${data.mahasiswa.prodi}</p>

                                <h5 class="mt-3">Nilai Output BPA Akademik</h5>
                                <table class="table table-bordered">
                                    <thead><tr><th>Bidang</th><th>Nilai BPA</th></tr></thead>
                                    <tbody>
                                        ${Object.entries(data.bpa_akademik).map(([k, v]) => `
                                                                                            <tr><td>${k}</td><td>${v.toFixed(4)}</td></tr>
                                                                                        `).join('')}
                                    </tbody>
                                </table>

                                <h5 class="mt-3">Nilai Output BPA Tes Bakat</h5>
                                <table class="table table-bordered">
                                    <thead><tr><th>Bidang</th><th>Nilai BPA</th></tr></thead>
                                    <tbody>
                                        ${Object.entries(data.bpa_tes).map(([k, v]) => `
                                                                                            <tr><td>${k}</td><td>${v.toFixed(4)}</td></tr>
                                                                                        `).join('')}
                                    </tbody>
                                </table>

                                <h5 class="mt-3">Output Dempster-Shafer (Gabungan)</h5>
                                <table class="table table-bordered">
                                    <thead><tr><th>Bidang</th><th>Belief (Kepercayaan)</th></tr></thead>
                                    <tbody>
                                        ${Object.entries(data.ds_result).map(([k, v]) => `
                                                                                            <tr><td>${k}</td><td>${(v*100).toFixed()}%</td></tr>
                                                                                        `).join('')}
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    <h4 class="text-primary">Rekomendasi: <strong>${data.rekomendasi}</strong></h4>
                                    <p>Nilai Kepercayaan Rekomendasi: <strong>${(data.nilai_kepercayaan_rekomendasi*100).toFixed()}%</strong></p>
                                </div>
                            `;

                            document.getElementById('modalContent').innerHTML = content;
                            // Pastikan Bootstrap JS dimuat dan modal diinisialisasi dengan benar
                            // Jika Anda menggunakan Bootstrap 5, ini sudah benar.
                            // Jika Bootstrap 4, gunakan: $('#detailModal').modal('show');
                            new bootstrap.Modal(document.getElementById('detailModal')).show();
                        })
                        .catch(err => {
                            console.error('Fetch error:', err); // Log error fetch
                            document.getElementById('modalContent').innerHTML =
                                `<p class="text-danger">Gagal memuat data: ${err.message}</p>`;
                        });
                });
            });
        });
    </script>
@endpush
