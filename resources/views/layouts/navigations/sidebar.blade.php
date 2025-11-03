<nav class="navbar navbar-expand-sm navbar-default">
    <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="{{ $active == 'dasbor' ? 'active' : '' }}">
                <a href="/"><i class="menu-icon fa fa-laptop"></i>Dasbor </a>
            </li>
            <li class="menu-title">Master Data</li>
            <li class="{{ $active == 'rayon' ? 'active' : '' }}">
                <a href="{{ route('rayon.index') }}"><i
                        class="menu-icon fa fa-user"></i>{{ ucwords(
                            str_replace(
                                '-',
                                '
                                            ',
                                $aplikasi['sebutan_rayon'],
                            ),
                        ) }}
                </a>
            </li>
            <li class="{{ $active == 'rt' ? 'active' : '' }}">
                <a href="{{ route('rt.index') }}"><i class="menu-icon fa fa-home"></i>RT </a>
            </li>
            <li class="{{ $active == 'periode' ? 'active' : '' }}">
                <a href="{{ route('periode.index') }}"><i class="menu-icon fa fa-calendar-check"></i>Periode</a>
            </li>
            <li class="{{ $active == 'subjek-pajak' ? 'active' : '' }}">
                <a href="{{ route('subjek-pajak.index') }}"><i class="menu-icon fa fa-address-card"></i>Subjek Pajak
                </a>
            </li>
            <li class="{{ $active == 'objek-pajak' ? 'active' : '' }}">
                <a href="{{ route('objek-pajak.index') }}"><i class="menu-icon fa fa-newspaper"></i>Objek Pajak </a>
            </li>

            <li class="menu-title">Transaksi</li>
            <li class="{{ $active == 'sppt' ? 'active' : '' }}">
                <a href="{{ route('sppt.index') }}"><i class="menu-icon fa fa-file-text"></i>SPPT</a>
            </li>
            <li class="{{ $active == 'pembayaran' ? 'active' : '' }}">
                <a href="{{ route('pembayaran.index') }}"><i class="menu-icon fa fa-credit-card"></i>Pembayaran </a>
            </li>
            <li class="menu-title">Laporan</li>
            <li class="menu-item-has-children dropdown {{ $activeDropdown == 'rekap' ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"> <i class="menu-icon fa fa-archive"></i>Rekap Pembayaran</a>
                <ul class="sub-menu children dropdown-menu {{ $activeDropdown == 'rekap' ? 'show' : '' }}">
                    <li><i class="menu-icon fa fa-clock"></i><a href="{{ route('rekap-waktu.index') }}"><span
                                class="{{ $active == 'rekap-waktu' ? 'text-info' : '' }}">Rekap Waktu</span></a></li>
                    <li><i class="menu-icon fa fa-times"></i><a href="{{ route('rekap-belum-bayar.index') }}"><span
                                class="{{ $active == 'rekap-belum-bayar' ? 'text-info' : '' }}">Rekap Belum
                                Bayar</span></a></li>
                    <li><i class="menu-icon fa fa-check"></i><a href="{{ route('rekap-lunas.index') }}"><span
                                class="{{ $active == 'rekap-lunas' ? 'text-info' : '' }}">Rekap Lunas</span></a></li>
                </ul>
            </li>
            <li class="{{ $active == 'cetak-rekap' ? 'active' : '' }}">
                <a href="{{ route('cetak-rekap.index') }}"><i class="menu-icon fa fa-file-pdf"></i>Cetak Rekap</a>
            </li>
            <li class="menu-title">Pengaturan</li>
            <li class="{{ $active == 'pengguna' ? 'active' : '' }}">
                <a href="{{ route('pengguna.index') }}"><i class="menu-icon fa fa-users"></i>Pengguna </a>
            </li>
            <li class="{{ $active == 'aplikasi' ? 'active' : '' }}">
                <a href="{{ route('aplikasi.index') }}"><i class="menu-icon fa fa-gear"></i>Aplikasi </a>
            </li>
            <li class="{{ in_array($active, ['otp', '2fa', 'otp-2fa']) ? 'active' : '' }}">
                <a href="{{ route('otp-2fa.index') }}"><i class="menu-icon fa fa-shield-alt"></i>OTP & 2FA </a>
            </li>
            <li class="{{ $active == 'database' ? 'active' : '' }}">
                <a href="{{ route('database.index') }}"><i class="menu-icon fa fa-database"></i>Database </a>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>
