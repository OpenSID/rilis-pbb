@php
    // Prepare styles to be injected into the auth layout head via $styles variable
    $styles = new \Illuminate\Support\HtmlString(
        '
<link nonce="' .
            csp_nonce() .
            '" rel="stylesheet" href="' .
            asset(' /css/auth/otp.css') .
            '">',
); @endphp
<x-auth-layout :styles="$styles" title="Login dengan 2FA">

    @section('form')
        <!-- Step 1: Enter Identifier (untuk direct access) -->
        <div id="identifierStep">
            <div class="text-center mb-3">
                <div class="mb-3">
                    <i class="fas fa-shield-alt fa-3x text-primary"></i>
                </div>
                <h4 class="mb-1">🔐 Login dengan 2FA</h4>
                <p class="text-muted">Masukkan nama pengguna atau email Anda</p>
                <small class="text-info d-block">Kode 2FA akan dikirim sesuai konfigurasi Anda (Email/Telegram)</small>
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
                            {{ __('Kirim Kode 2FA') }}
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

        <!-- Step 2: 2FA Code Entry -->
        <div id="codeStep">
            <div class="text-center mb-3">
                <div class="mb-3">
                    <i class="fas fa-mobile-alt fa-3x text-success"></i>
                </div>
                <h4 class="mb-1">📱 Masukkan Kode 2FA</h4>
                <p class="text-muted" id="codeSentMessage">
                    @if (isset($autoSent) && $autoSent)
                        Kode 2FA telah dikirim ke
                        <strong>{{ isset($channel) && $channel === 'email' ? 'email' : 'Telegram' }}</strong> Anda
                        @if (isset($maskedIdentifier))
                            <br><small class="text-info">{{ $maskedIdentifier }}</small>
                        @endif
                    @endif
                </p>
            </div>

            <form id="codeForm">
                @csrf
                <div class="input-group mb-3">
                    <input type="tel" class="form-control form-control-lg text-center" name="code" id="code"
                        pattern="[0-9]{6}" maxlength="6" placeholder="000000" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-key {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
                        Kode 2FA akan dikirim ke email atau Telegram yang terdaftar
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

                // Show appropriate step based on auto-sent status
                @if (isset($autoSent) && $autoSent)
                    $('#codeStep').show();
                    $('#identifierStep').hide();
                    $('#code').focus();
                    startCountdown(300); // 5 minutes
                    startResendCountdown(60); // 60 seconds
                @else
                    $('#codeStep').hide();
                    $('#identifierStep').show();
                    $('#identifier').focus();
                @endif

                // Submit identifier form
                $('#identifierForm').submit(function(e) {
                    e.preventDefault();

                    const identifier = $('#identifier').val().trim();
                    if (!identifier) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Nama pengguna atau email wajib diisi'
                        });
                        return;
                    }

                    const btn = $(this).find('button[type="submit"]');
                    const originalText = btn.html();

                    btn.prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...');

                    $.ajax({
                        url: '{{ route('2fa-login.send') }}',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.success) {
                                $('#identifierStep').hide();
                                $('#codeStep').show();
                                $('#code').focus();
                                
                                // Update message with masked identifier if available
                                if (response.maskedIdentifier) {
                                    $('#codeSentMessage').html(
                                        'Kode 2FA telah dikirim ke <strong>' + response.channel + '</strong> Anda<br>' +
                                        '<small class="text-info">' + response.maskedIdentifier + '</small>'
                                    );
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    timer: 2000
                                });

                                startCountdown(300); // 5 minutes
                                startResendCountdown(60); // 60 seconds
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Gagal mengirim kode'
                                });
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal mengirim kode'
                            });
                        },
                        complete: function() {
                            btn.prop('disabled', false).html(originalText);
                        }
                    });
                });

                // Submit code form
                $('#codeForm').submit(function(e) {
                    e.preventDefault();

                    const code = $('#code').val();
                    if (code.length !== 6) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Kode 2FA harus 6 digit'
                        });
                        $('#code').focus();
                        return;
                    }

                    const btn = $(this).find('button[type="submit"]');
                    const originalText = btn.html();

                    btn.prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin mr-2"></i>Memverifikasi...');

                    $.ajax({
                        url: '{{ route('2fa-login.verify') }}',
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
                                $('#code').val('').focus();
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Verifikasi gagal'
                            });
                            $('#code').val('').focus();
                        },
                        complete: function() {
                            btn.prop('disabled', false).html(originalText);
                        }
                    });
                });

                // Resend code
                $('#resendBtn').click(function() {
                    const btn = $(this);
                    const originalText = btn.html();

                    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...');

                    $.ajax({
                        url: '{{ route('2fa-login.resend') }}',
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

                // Auto-format code input
                $('#code').on('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length === 6) {
                        $('#codeForm').submit();
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

                // Initialize countdown timers on page load
                startCountdown(300); // 5 minutes
                startResendCountdown(60); // 60 seconds

                // Focus pada kode saat halaman dimuat
                $('#code').focus();
            });
        </script>
    @endpush

</x-auth-layout>
