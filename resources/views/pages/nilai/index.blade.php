@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Data Nilai Akademik</h4>
                            <a href="{{ route('admin.nilai.create') }}" class="btn btn-primary btn-icon-text">
                                <i class="ti-plus btn-icon-prepend"></i> Tambah Nilai
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="myDataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mahasiswa</th>
                                        <th>Mata Kuliah</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $index => $n)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $n->mahasiswa->nama }}</td>
                                            <td>{{ $n->matakuliah }}</td>
                                            <td>{{ $n->nilai }}</td>
                                            <td>
                                                <a href="{{ route('admin.nilai.edit', $n->id) }}" class="btn btn-info"><i
                                                        class="mdi mdi-pencil"></i></a>
                                                <form action="{{ route('admin.nilai.destroy', $n->id) }}" method="POST"
                                                    class="d-inline form-hapus" data-nama="{{ $n->mahasiswa->nama }}"
                                                    data-matkul="{{ $n->matakuliah }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger"><i
                                                            class="mdi mdi-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Belum ada data.</td>
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
                let matkul = form.getAttribute('data-matkul');

                Swal.fire({
                    title: 'Hapus Nilai Matkul ' + matkul + '?',
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
