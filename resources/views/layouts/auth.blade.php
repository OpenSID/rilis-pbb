@extends('layouts.includes.header', ['favicon' => $favicon])

@section('body')

    <!-- Content -->
    <section id="content">
        <body id="form-login" style="background-image:url('{{ asset($latar_login)}}">

            <div class="sufee-login d-flex align-content-center flex-wrap">
                <div class="container">
                    <div class="login-content">
                        <div class="login-form">
                            <!-- Logo -->
                            <div class="login-logo text-center">
                                <a href="./">
                                    <img class="align-content" src="{{ asset($logo_aplikasi)}}" alt="logo-aplikasi-pbb" height="75px">
                                </a>
                            </div>

                            @yield('form')

                            <hr>
                            <!-- Copyright -->
                            <div class="text-center">
                                <small>Hak Cipta &copy; 2020 - <?= date('Y'); ?> <a href="http://opendesa.id">OpenDesa</a>
                                <br/>
                                <a href="https://github.com/OpenSID/rilis-pbb" target="_blank">Aplikasi PBB {{ pbb_version() }}</a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>

        {{ $slot }}
    </section>

    @include('layouts.includes.scripts')
@endsection
