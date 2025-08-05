@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Data Mahasiswa</h4>
                            <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary btn-icon-text">
                                <i class="ti-plus btn-icon-prepend"></i> Tambah Mahasiswa
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="myDataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Prodi</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index=> $m)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $m->nama }}</td>
                                            <td>{{ $m->nim }}</td>
                                            <td>{{ $m->prodi }}</td>
                                            <td>{{ $m->user->email ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.mahasiswa.edit', $m->id) }}"
                                                    class="btn btn-info"><i class="mdi mdi-pencil"></i></a>
                                                <form action="{{ route('admin.mahasiswa.destroy', $m->id) }}" method="POST"
                                                    class="d-inline form-hapus" data-nama="{{ $m->nama }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger"><i
                                                            class="mdi mdi-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">Belum ada data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.form-hapus').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                let nama = form.getAttribute('data-nama');

                Swal.fire({
                    title: 'Hapus ' + nama + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
