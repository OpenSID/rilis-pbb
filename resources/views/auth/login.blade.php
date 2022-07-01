<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.includes._base', ['favicon' => $favicon])
        <title>Login | Pencatatan Pajak</title>
    </head>

    <body id="form-login" style="background-image:url('{{ asset($latar_login)}}">

        <div class="sufee-login d-flex align-content-center flex-wrap">
            <div class="container">
                <div class="login-content">
                    <div class="login-form">
                        <!-- Logo -->
                        <div class="login-logo text-center">
                            <a href="/">
                                <img class="align-content" src="{{ asset($logo_aplikasi)}}" alt="logo-aplikasi-pbb" height="75px">
                            </a>
                        </div>
                        <hr/>

                        <!-- Form -->
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Nama Pengguna / Email</label>
                                <input type="text" value="{{ old('username') }}" name="username" id="username" class="form-control" placeholder="Nama Pengguna / Email" required="required" data-validate-linked='email'/>
                            </div>

                            <div class="form-group py-3">
                                <label>Kata Sandi</label>
                                <input type="password" value="{{ old('password') }}" name="password" id="password" class="form-control" placeholder="Kata Sandi" required="">
                            </div>

                            <div class="">
                                @error('message')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    <br/>
                                @enderror
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" id="checkbox" class="form-checkbox"> Tampilkan kata sandi
                                <label class="pull-right">
                                    <a href="#">Lupa Kata Sandi?</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success btn-flat m-b-3 m-t-30 mt-2">Masuk</button>
                        </form>
                        <hr/>

                        <!-- Copyright -->
                        <div class="text-center">
                            <small>Hak Cipta &copy; 2020 - {{ date('Y') }} <a href="http://opendesa.id">OpenDesa</a>
                            <br/>
                            <a href="https://github.com/OpenSID/rilis-pbb" target="_blank">Aplikasi PBB @include('layouts.includes._version')</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div data-backdrop="static" data-keyboard="false" class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel" aria-hidden="true" style="top:0;padding-top: 160px"><div class="modal-dialog modal-sm" role="document" style="vertical-align: middle !important;">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="loader"></div>
                        <div clas="loader-txt">
                            <p>Mohon Tunggu Sebentar ...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        @include('layouts.includes.scripts')

        <script>
        $('document').ready(function() {
            var pass = $("#password");
            $('#checkbox').click(function() {
                if (pass.attr('type') === "password") {
                    pass.attr('type', 'text');
                } else {
                    pass.attr('type', 'password')
                }
            });
        });
        </script>
        <!-- /.scripts -->

    </body>
</html>
