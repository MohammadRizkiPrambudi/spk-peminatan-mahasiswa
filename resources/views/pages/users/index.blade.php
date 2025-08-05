@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Data User</h4>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-icon-text">
                                <i class="ti-plus btn-icon-prepend"></i> Tambah User
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="myDataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline form-hapus" data-nama="{{ $user->name }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"><i
                                                            class="mdi mdi-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Belum ada data user.</td>
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
