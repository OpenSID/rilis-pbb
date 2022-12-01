<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="./"><img src="{{asset($logo_aplikasi)}}" alt="Logo" width="auto" height="42px"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{asset('/build/images/opendesa/pengaturan-aplikasi/logo-surat.png')}}" alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu d-flex align-items-center">
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
                    {{-- <a class="nav-link" href="#"><i class="fa fa-user"></i>Profil</a> --}}

                    <a class="nav-link" href="{{ route('aplikasi.index') }}"><i class="fa fa-cog"></i>Pengaturan</a>

                    <a href="healthcheck" class="nav-link"><i class="fa fa-info-circle"></i>Info</a>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn nav-link">
                            <i class="fa fa-power-off"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>

            <a class="btn" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title }}">
                <i class="fas fa-question-circle"></i>
            </a>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">{{ $title }}</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="accordion" id="accordionExample">
                        @foreach ($informations as $info)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $info['id'] }}">
                                    <button class="accordion-button {{ $info['collapsed'] }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $info['target'] }}" aria-expanded="true" aria-controls="{{ $info['target'] }}">
                                        {{ $info['title'] }}
                                    </button>
                                </h2>
                                <div id="{{ $info['target'] }}" class="accordion-collapse collapse {{ $info['show'] }}" aria-labelledby="{{ $info['id'] }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {{ $info['description'] }}
                                        <a href="{{ $info['link'] }}" target="_blank"><span class="text-primary {{ $info['link'] == "" ? 'd-none' : 'd-inline' }}">Selengkapnya di Panduan.</span></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>

