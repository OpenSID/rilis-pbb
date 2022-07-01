<nav class="navbar navbar-expand-sm navbar-default">
    <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li>
                <a href="/"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
            </li>
            <li class="menu-title">Master Data</li>
            <li>
                <a href="{{ route('rayon.index') }}"><i class="menu-icon fa fa-user"></i>Rayon </a>
            </li>
            <li>
                <a href="{{ route('rt.index') }}"><i class="menu-icon fa fa-home"></i>RT </a>
            </li>
            <li>
                <a href="{{ route('periode.index') }}"><i class="menu-icon fa fa-calendar-check"></i>Periode</a>
            </li>
            <li>
                <a href="{{ route('subjek-pajak.index') }}"><i class="menu-icon fa fa-address-card"></i>Subjek Pajak </a>
            </li>
            <li>
                <a href="{{ route('objek-pajak.index') }}"><i class="menu-icon fa fa-newspaper"></i>Objek Pajak </a>
            </li>

            <li class="menu-title">Transaksi</li>
            <li>
                <a href="{{ route('sppt.index') }}"><i class="menu-icon fa fa-file-text"></i>SPPT</a>
            </li>
            <li>
                <a href="{{ route('pembayaran.index') }}"><i class="menu-icon fa fa-credit-card"></i>Pembayaran </a>
            </li>
            <li class="menu-title">Laporan</li>
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-archive"></i>Rekap Pembayaran</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="menu-icon fa fa-clock"></i><a href="{{ route('rekap-waktu.index') }}">Rekap Waktu</a></li>
                    <li><i class="menu-icon fa fa-times"></i><a href="{{ route('rekap-belum-bayar.index') }}">Rekap Belum Bayar</a></li>
                    <li><i class="menu-icon fa fa-check"></i><a href="{{ route('rekap-lunas.index') }}">Rekap Lunas</a></li>
                </ul>
            </li>
            {{-- <li>
                <a href="rekap"><i class="menu-icon fa fa-file-pdf"></i>Cetak Rekap</a>
            </li> --}}
            <li class="menu-title">Pengaturan</li>
            <li>
                <a href="{{ route('pengguna.index') }}"><i class="menu-icon fa fa-users"></i>Pengguna </a>
            </li>
            <li>
                <a href="{{ route('aplikasi.index') }}"><i class="menu-icon fa fa-gear"></i>Aplikasi </a>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>
