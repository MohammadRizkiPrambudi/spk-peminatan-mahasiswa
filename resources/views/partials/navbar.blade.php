<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-3" href="{{ route('dashboard') }}">SPK Peminatan</a>

        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">SPK</a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">

        </ul>
        <ul class="navbar-nav navbar-nav-right">

            {{-- Bagian Profil dan Logout yang Disesuaikan --}}
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    {{-- <img src="{{ asset('assets/images/faces/face28.jpg') }}" alt="profile" /> --}}
                    <span class="nav-profile-name ml-2">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    {{-- Link ke Pengaturan Profil menggunakan route Breeze 'profile.edit' --}}
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="ti-settings text-primary"></i>
                        Profil
                    </a>

                    <div class="dropdown-divider"></div> {{-- Pembatas opsional --}}

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </a>
                    </form>
                </div>
            </li>
            {{-- Akhir Bagian Profil dan Logout --}}

            <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link" href="#">
                    <i class="icon-ellipsis"></i>
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
