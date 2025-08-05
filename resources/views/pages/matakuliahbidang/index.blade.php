@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Daftar Relasi Matakuliah & Bidang</h4>
                            <a href="{{ route('admin.matakuliah-bidang.create') }}" class="btn btn-primary btn-icon-text">
                                <i class="ti-plus btn-icon-prepend"></i> Tambah
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="myDataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Matakuliah</th>
                                        <th>Bidang</th>
                                        <th>Bobot</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index => $d)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $d->matakuliah }}</td>
                                            <td>{{ $d->bidang }}</td>
                                            <td>{{ $d->bobot }}</td>
                                            <td>
                                                <a href="{{ route('admin.matakuliah-bidang.edit', $d->id) }}"
                                                    class="btn btn-info"><i class="mdi mdi-pencil"></i></a>
                                                <form action="{{ route('admin.matakuliah-bidang.destroy', $d->id) }}"
                                                    method="POST" class="d-inline form-hapus">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"><i
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


                Swal.fire({
                    title: 'Yakin Akan Menghapus data ini ?',
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
