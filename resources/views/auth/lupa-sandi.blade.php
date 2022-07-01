<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.includes._base')
        <title>Lupa Kata Sandi | Pencatatan Pajak</title>
    </head>

    <body id="form-login" style="background-image:url('{{ asset('/build/images/opendesa/pengaturan-aplikasi/background.jpg')}}">

        <div class="sufee-login d-flex align-content-center flex-wrap">
            <div class="container">
                <div class="login-content">
                    <div class="login-form">
                        <!-- Logo -->
                        <div class="login-logo text-center">
                            <a href="/">
                                <img class="align-content" src="{{ asset('/build/images/opendesa/pengaturan-aplikasi/logo-aplikasi.png')}}" alt="">
                            </a>
                        </div>

                        <!-- Form -->
                        <form>
                            <div class="form-group">
                                <label>Alamat Email</label>
                                <input type="email" class="form-control" placeholder="Email">
                                </div>
                                <button type="submit" class="btn btn-primary btn-flat m-b-15">Kirim</button>
                        </form>

                        <hr>
                        <!-- Copyright -->
                        <div class="text-center">
                            <small>Hak Cipta &copy; 2020 - <?= date('Y'); ?> <a href="http://opendesa.id">OpenDesa</a>
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
    </body>
</html>
