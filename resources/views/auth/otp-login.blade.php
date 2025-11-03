@php
    // Prepare styles to be injected into the auth layout head via $styles variable
    $styles = new \Illuminate\Support\HtmlString(
        '<link nonce="' . csp_nonce() . '" rel="stylesheet" href="' . asset('/css/auth/otp.css') . '">',
    );
@endphp

<x-auth-layout :styles="$styles" title="Login tanpa password">

    @section('form')
        <!-- Step 1: Enter Identifier -->
        <div id="identifierStep">
            <div class="text-center mb-3">
                <div class="mb-3">
                    <i class="fas fa-shield-alt fa-3x text-primary"></i>
                </div>
                <h4 class="mb-1">🔐 Login Tanpa Password</h4>
                <p class="text-muted">Masukkan nama pengguna atau email Anda</p>
                <small class="text-info d-block">Kode OTP akan dikirim sesuai konfigurasi Anda (Email/Telegram)</small>
            </div>

            <form id="identifierForm">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control @error('identifier') is-invalid @enderror" name="identifier"
                        id="identifier" placeholder="Nama Pengguna / Email" value="{{ old('identifier') }}" required autofocus>

                    @error('identifier')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success btn-flat m-b-3 w-100">
                            <i class="fas fa-paper-plane me-2"></i>
                            {{ __('Kirim Kode OTP') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="text-center mt-3">
                <p class="mb-1">
                    <a href="{{ route('login') }}" class="text-center">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali ke Login Normal
                    </a>
                </p>
            </div>
        </div>

        <!-- Step 2: Enter OTP (Hidden initially) -->
        <div id="otpStep">
            <div class="text-center mb-3">
                <div class="mb-3">
                    <i class="fas fa-mobile-alt fa-3x text-success"></i>
                </div>
                <h4 class="mb-1">📱 Masukkan Kode OTP</h4>
                <p class="text-muted" id="otpSentMessage"></p>
            </div>

            <form id="otpForm">
                @csrf
                <div class="input-group mb-3">
                    <input type="tel" class="form-control form-control-lg text-center" name="otp" id="otp"
                        pattern="[0-9]{6}" maxlength="6" placeholder="000000" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-key {{ config('adminlte.classes_auth_icon', '') }}"
                                style="line-height: 2 !important;"></span>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-3">
                    <small class="text-muted">
                        Kode berlaku selama <span id="countdown" class="font-weight-bold text-primary">5:00</span> menit
                    </small>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success btn-flat m-b-15 w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            {{ __('Masuk') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="text-center mt-3">
                <button type="button" class="btn btn-link" id="resendBtn">
                    <i class="fas fa-redo me-1"></i>
                    Kirim Ulang (<span id="resendCountdown">60</span>s)
                </button>
            </div>
        </div>
    @endsection

    @section('auth_footer')
        <div class="text-center">
            <div class="row">
                <div class="col">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        OTP akan dikirim ke email atau Telegram yang terdaftar
                    </small>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="badge badge-info me-2">
                            <i class="fas fa-envelope me-1"></i>
                            Email
                        </span>
                        <span class="badge badge-info">
                            <i class="fab fa-telegram me-1"></i>
                            Telegram
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script nonce="{{ csp_nonce() }}">
            document.addEventListener("DOMContentLoaded", function(event) {
                let countdownTimer;
                let resendTimer;
                $('#otpStep').hide();
                // Submit identifier form
                $('#identifierForm').submit(function(e) {
                    e.preventDefault();

                    const identifier = $('#identifier').val().trim();
                    if (!identifier) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Silakan masukkan email atau Telegram Chat ID'
                        });
                        return;
                    }

                    const btn = $(this).find('button[type="submit"]');
                    const originalText = btn.html();

                    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...');

                    $.ajax({
                        url: '{{ route('otp-login.send') }}',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#identifierStep').hide();
                            $('#otpStep').show();
                            $('#otpSentMessage').html(
                                'Kode OTP telah dikirim ke <strong>' +
                                (response.channel === 'email' ? 'email' : 'Telegram') +
                                '</strong> Anda'
                            );
                            $('#otp').focus();

                            // Start countdown
                            startCountdown(300); // 5 minutes
                            startResendCountdown(60); // 60 seconds

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal mengirim kode OTP'
                            });
                        },
                        complete: function() {
                            btn.prop('disabled', false).html(originalText);
                        }
                    });
                });

                // Submit OTP form
                $('#otpForm').submit(function(e) {
                    e.preventDefault();

                    const otp = $('#otp').val();
                    if (otp.length !== 6) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Kode OTP harus 6 digit'
                        });
                        $('#otp').focus();
                        return;
                    }

                    const btn = $(this).find('button[type="submit"]');
                    const originalText = btn.html();

                    btn.prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin mr-2"></i>Memverifikasi...');

                    $.ajax({
                        url: '{{ route('otp-login.verify') }}',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });

                                // Redirect to dashboard
                                setTimeout(() => {
                                    window.location.href = response.redirect;
                                }, 1000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Verifikasi gagal'
                                });
                                $('#otp').val('').focus();
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Verifikasi gagal'
                            });
                            $('#otp').val('').focus();
                        },
                        complete: function() {
                            btn.prop('disabled', false).html(originalText);
                        }
                    });
                });

                // Resend OTP
                $('#resendBtn').click(function() {
                    const btn = $(this);
                    const originalText = btn.html();

                    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...');

                    $.ajax({
                        url: '{{ route('otp-login.resend') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            startResendCountdown(60);
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal mengirim ulang'
                            });
                        },
                        complete: function() {
                            btn.html(originalText);
                        }
                    });
                });

                // Auto-format OTP input
                $('#otp').on('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length === 6) {
                        $('#otpForm').submit();
                    }
                });

                function startCountdown(seconds) {
                    let timeLeft = seconds;
                    countdownTimer = setInterval(function() {
                        const minutes = Math.floor(timeLeft / 60);
                        const secs = timeLeft % 60;
                        $('#countdown').text(minutes + ':' + (secs < 10 ? '0' : '') + secs);

                        if (timeLeft <= 0) {
                            clearInterval(countdownTimer);
                            $('#countdown').text('Kedaluwarsa').addClass('countdown-expired');
                        }
                        timeLeft--;
                    }, 1000);
                }

                function startResendCountdown(seconds) {
                    let timeLeft = seconds;
                    $('#resendBtn').prop('disabled', true);

                    resendTimer = setInterval(function() {
                        $('#resendCountdown').text(timeLeft);

                        if (timeLeft <= 0) {
                            clearInterval(resendTimer);
                            $('#resendBtn').prop('disabled', false);
                            $('#resendBtn').html('<i class="fas fa-redo mr-1"></i>Kirim Ulang');
                        }
                        timeLeft--;
                    }, 1000);
                }

                // Focus pada identifier saat halaman dimuat
                $('#identifier').focus();
            });
        </script>
    @endpush

</x-auth-layout>
