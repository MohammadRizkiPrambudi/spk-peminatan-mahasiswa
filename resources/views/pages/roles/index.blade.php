@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Daftar Role</h4>
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-icon-text">
                                <i class="ti-plus btn-icon-prepend"></i> Tambah Role
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="myDataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $index=> $role)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning"><i
                                                        class="mdi mdi-pencil"></i></a>
                                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                                    class="d-inline form-hapus" data-role="{{ $role->name }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger"><i
                                                            class="mdi mdi-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">Belum ada data.</td>
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

                let role = form.getAttribute('data-role');

                Swal.fire({
                    title: 'Hapus Role ' + role + '?',
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
