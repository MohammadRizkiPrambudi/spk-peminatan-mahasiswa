<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @role('admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="ti-home menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.mahasiswa.index') }}">
                    <i class="ti-user menu-icon"></i>
                    <span class="menu-title">Data Mahasiswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.matakuliah-bidang.index') }}">
                    <i class="ti-book menu-icon"></i>
                    <span class="menu-title">Mata Kuliah</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.nilai.index') }}">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Nilai Akademik</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.minat.index') }}">
                    <i class="ti-heart menu-icon"></i>
                    <span class="menu-title">Preferensi Minat</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.tes.index') }}">
                    <i class="ti-write menu-icon"></i>
                    <span class="menu-title">Tes Bakat</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.proses.index') }}">
                    <i class="ti-reload menu-icon"></i>
                    <span class="menu-title">Proses Perhitungan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.hasil.index') }}">
                    <i class="ti-bar-chart-alt menu-icon"></i>
                    <span class="menu-title">Hasil Rekomendasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                    aria-controls="form-elements">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Management User</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="form-elements">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.roles.index') }}">Role</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">User</a></li>
                    </ul>
                </div>
            </li>
        @endrole
        @role('mahasiswa')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="ti-home menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('input.form') }}">
                    <i class="ti-pencil menu-icon"></i>
                    <span class="menu-title">Input Nilai</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tes.form') }}">
                    <i class="ti-write  menu-icon"></i>
                    <span class="menu-title">Tes Bakat</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('rekomendasi.self') }}">
                    <i class="ti-bar-chart-alt menu-icon"></i>
                    <span class="menu-title">Hasil Rekomendasi</span>
                </a>
            </li>
        @endrole
    </ul>
</nav>
