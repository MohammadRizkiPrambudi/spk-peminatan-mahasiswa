@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Preferensi Minat Mahasiswa</h4>
                            <a href="{{ route('admin.minat.create') }}" class="btn btn-primary btn-icon-text">
                                <i class="ti-plus btn-icon-prepend"></i> Tambah Preferensi
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="myDataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mahasiswa</th>
                                        <th>Bidang</th>
                                        <th>Tingkat Minat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $index=> $row)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $row->mahasiswa->nama }}</td>
                                            <td>{{ $row->bidang }}</td>
                                            <td>{{ ucfirst($row->tingkat_minat) }}</td>
                                            <td>
                                                <a href="{{ route('admin.minat.edit', $row->id) }}"
                                                    class="btn btn-primary"><i class="mdi mdi-pencil"></i></a>
                                                <form action="{{ route('admin.minat.destroy', $row->id) }}" method="POST"
                                                    class="d-inline form-hapus" data-nama="{{ $row->mahasiswa->nama }}"
                                                    data-bidang="{{ $row->bidang }}">
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
                let bidang = form.getAttribute('data-bidang');

                Swal.fire({
                    title: 'Hapus Preferensi Bidang ' + bidang + '?',
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
