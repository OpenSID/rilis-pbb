<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="./"><img src="{{asset($logo_aplikasi)}}" alt="Logo" width="auto" height="42px"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{asset('/build/images/opendesa/pengaturan-aplikasi/logo-surat.png')}}" alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">
            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="me-2">{{ $akun_pengguna }}</span>
                    @if(Auth::user()->photo)
                        <img class="user-avatar rounded-circle" src="{{asset('storage/pengguna/'. Auth::user()->photo)}}" alt="foto-pengguna" height="42px">
                    @else
                        <img class="user-avatar rounded-circle" src="{{asset('/build/images/opendesa/pengaturan-aplikasi/pengguna.png')}}" alt="foto-pengguna" height="42px">
                    @endif
                </a>

                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="#"><i class="fa fa-user"></i>Profil</a>

                    <a class="nav-link" href="#"><i class="fa fa-cog"></i>Pengaturan</a>

                    <a href="healthcheck" class="nav-link"><i class="fa fa-info-circle"></i>Info</a>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn nav-link">
                            <i class="fa fa-power-off"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
