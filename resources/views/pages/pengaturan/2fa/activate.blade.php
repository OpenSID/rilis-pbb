<x-app-layout title="Aktivasi 2FA">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Pengaturan" active="2FA"></x-breadcrumbs>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pages/pengaturan/otp.css') }}">
    @endsection
    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-8">
                    @if (!$user->twofa_enabled)
                        <!-- Wizard Container -->
                        <div id="twofaWizard">
                            <!-- Wizard Progress -->
                            <div class="card mb-3" id="wizardProgress">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="text-center mb-3">
                                            <div class="step-info">
                                                <strong id="stepTitle">Langkah 1: Pengaturan Channel</strong>
                                                <small class="text-muted d-block" id="stepDesc">Pilih metode pengiriman
                                                    kode
                                                    2FA</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 1: Setup -->
                            <div class="wizard-content" id="step1Content">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h3 class="card-title">
                                            <i class="fas fa-shield-alt mr-2"></i>
                                            Setup Autentikasi 2FA
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            <strong>Informasi:</strong> 2FA (Two-Factor Authentication) akan menjadi
                                            alternatif
                                            login tambahan untuk meningkatkan keamanan akun Anda.
                                            Username dan password tetap dapat digunakan seperti biasa.
                                        </div>
                                        <form id="twofaSetupForm">
                                            @csrf
                                            <div class="form-group">
                                                <label class="font-weight-bold">Pilih Channel Pengiriman:</label>
                                                <div class="mt-2">
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="methodEmail"
                                                            name="method" value="email" checked>
                                                        <label for="methodEmail" class="custom-control-label">
                                                            <i class="fas fa-envelope text-primary mr-2"></i>
                                                            <strong>Email</strong>
                                                            <small class="text-muted d-block">Kode 2FA akan dikirim ke email
                                                                Anda</small>
                                                        </label>
                                                    </div>
                                                    <div class="custom-control custom-radio mt-2">
                                                        <input class="custom-control-input" type="radio"
                                                            id="methodTelegram" name="method" value="telegram">
                                                        <label for="methodTelegram" class="custom-control-label">
                                                            <i class="fab fa-telegram text-info mr-2"></i>
                                                            <strong>Telegram</strong>
                                                            <small class="text-muted d-block">Kode 2FA akan dikirim melalui
                                                                bot
                                                                Telegram</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="emailSection" class="form-group">
                                                <label for="emailInput">Email Address:</label>
                                                <input type="email" class="form-control" id="emailInput" name="contact"
                                                    value="{{ $user->email }}" placeholder="Masukkan email Anda">
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Pastikan email aktif dan dapat menerima pesan
                                                </small>
                                            </div>
                                            <div id="telegramSection" class="form-group d-none">
                                                <label for="telegramInput">Telegram Chat ID:</label>
                                                <input type="text" class="form-control" id="telegramInput" name="contact"
                                                    value="{{ $user->telegram_id }}"
                                                    placeholder="Masukkan Telegram Chat ID">
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Hubungi bot @userinfobot dan ketik /start untuk mendapatkan Chat ID
                                                </small><br>
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Hubungi bot {{ env('TELEGRAM_BOT_NAME', 'belum diset') }} dan ketik
                                                    /start
                                                    agar bot telegram dapat mengirim kode 2FA ke Anda
                                                </small>
                                            </div>
                                            <div class="form-group mt-4">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-paper-plane mr-2"></i>
                                                    Kirim Kode Aktivasi
                                                </button><br>
                                                <small class="form-text text-muted mt-2">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Setelah mengirim, Anda akan diminta memasukkan kode verifikasi
                                                </small>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Verification -->
                            <div class="wizard-content d-none" id="step2Content">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h3 class="card-title">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Verifikasi Kode Aktivasi
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-success" id="twofaSentMessage"></div>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            <strong>Langkah Terakhir:</strong> Masukkan kode 6 digit yang telah dikirim
                                            untuk
                                            menyelesaikan aktivasi 2FA.
                                        </div>
                                        <form id="twofaVerifyForm">
                                            @csrf
                                            <div class="form-group">
                                                <label for="twofaCode" class="font-weight-bold">Masukkan Kode
                                                    Aktivasi:</label>
                                                <input type="tel"
                                                    class="form-control form-control-lg text-center otp-input"
                                                    id="twofaCode" name="code"
                                                    pattern="{{ '[0-9]{' . ($twoFactorConfig['length'] ?? 6) . '}' }}"
                                                    maxlength="{{ $twoFactorConfig['length'] ?? 6 }}"
                                                    placeholder="{{ str_repeat('0', $twoFactorConfig['length'] ?? 6) }}">
                                                <small class="form-text text-muted text-center">
                                                    Kode berlaku selama <span
                                                        id="countdown">{{ $twoFactorConfig['expires_minutes'] ?? 5 }}:00</span>
                                                    menit
                                                </small>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-success btn-sm mr-2">
                                                    <i class="fas fa-check mr-2"></i>
                                                    Verifikasi & Aktifkan
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                                    id="resendBtn" disabled>
                                                    <i class="fas fa-redo mr-2"></i>
                                                    Kirim Ulang (<span
                                                        id="resendCountdown">{{ $twoFactorConfig['resend_seconds'] ?? 30 }}</span>s)
                                                </button>
                                            </div>
                                        </form>
                                        <div class="text-center mt-3">
                                            <button type="button" class="btn btn-link btn-sm" id="backToSetup">
                                                <i class="fas fa-arrow-left mr-1"></i>
                                                Kembali ke Pengaturan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Success Card -->
                        <div class="card d-none" id="successCard">
                            <div class="card-header bg-success text-white">
                                <h3 class="card-title">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    2FA Berhasil Diaktifkan!
                                </h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-4">
                                    <i class="fas fa-shield-check text-success" style="font-size: 72px;"></i>
                                </div>
                                <h4 class="text-success mb-3">Selamat!</h4>
                                <p class="lead">Fitur 2FA telah berhasil diaktifkan di akun Anda.</p>
                                <div class="alert alert-info mt-4">
                                    <h6><strong>Langkah Selanjutnya:</strong></h6>
                                    <p class="mb-0">Anda sekarang dapat menggunakan login 2FA sebagai alternatif yang
                                        lebih
                                        aman. Silakan logout dan coba fitur "Login dengan 2FA" di halaman login.</p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ url('/admin') }}" class="btn btn-primary btn-sm mr-2">
                                        <i class="fas fa-home mr-2"></i>
                                        Ke Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Status 2FA Aktif -->
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <strong class="card-title">
                                    <i class="fas fa-shield-check me-2"></i>
                                    Status 2FA: <span class="badge bg-primary text-white ms-2">AKTIF</span>
                                </strong>
                            </div>
                            <div class="card-body">
                                <!-- Informasi Detail 2FA -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <h6 class="text-primary"><i
                                                    class="fas fa-broadcast-tower me-2"></i><strong>Channel
                                                    Aktif:</strong></h6>
                                            <div class="mt-2">
                                                <span class="badge bg-primary text-white ms-2">
                                                    @php
                                                        $channels = !empty($user->otp_channel)
                                                            ? json_decode($user->otp_channel, true)
                                                            : [];
                                                        $currentMethod =
                                                            is_array($channels) && count($channels) > 0
                                                                ? $channels[0]
                                                                : '';
                                                    @endphp
                                                    @if ($currentMethod === 'email')
                                                        <i class="fas fa-envelope me-1"></i> Email
                                                    @else
                                                        <i class="fab fa-telegram me-1"></i> Telegram
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <h6 class="text-primary"><i
                                                    class="fas fa-id-card me-2"></i><strong>Identifier:</strong></h6>
                                            <div class="mt-2">
                                                <code class="bg-light p-2 rounded">{{ $user->otp_identifier }}</code>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <h6 class="text-primary"><i
                                                    class="fas fa-calendar-check me-2"></i><strong>Status:</strong></h6>
                                            <div class="mt-2">
                                                <small class="text-success d-block">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Aktif sejak {{ $user->updated_at->diffForHumans() }}
                                                </small>
                                                <small class="text-muted">
                                                    {{ $user->updated_at->format('d M Y, H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Keamanan -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="alert alert-info border-0">
                                            <h6 class="text-info mb-2"><i class="fas fa-shield-alt mr-2"></i>Status
                                                Keamanan
                                            </h6>
                                            <div class="row text-sm">
                                                <div class="col-md-4">
                                                    <i class="fas fa-check text-success mr-2"></i>
                                                    <strong>Two-Factor Authentication</strong>
                                                </div>
                                                <div class="col-md-4">
                                                    <i class="fas fa-check text-success mr-2"></i>
                                                    <strong>Akses Cepat Tanpa Password</strong>
                                                </div>
                                                <div class="col-md-4">
                                                    <i class="fas fa-check text-success mr-2"></i>
                                                    <strong>Perlindungan Anti-Phishing</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Cara Menggunakan -->
                                <div class="mb-4">
                                    <h6 class="text-primary"><i class="fas fa-question-circle me-2"></i><strong>Cara
                                            Menggunakan
                                            2FA:</strong></h6>
                                    <ol class="text-sm px-5">
                                        <li>Di halaman login, pilih <strong>"Login dengan 2FA"</strong></li>
                                        <li>Masukkan identifier Anda: <code>{{ $user->otp_identifier }}</code></li>
                                        <li>Kode 2FA akan dikirim ke channel yang aktif</li>
                                        <li>Masukkan kode 6 digit untuk masuk ke sistem</li>
                                    </ol>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            2FA adalah tambahan keamanan, login normal tetap tersedia
                                        </small>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-warning" id="disableTwofaBtn">
                                            <i class="fas fa-times-circle me-2"></i>
                                            Nonaktifkan 2FA
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    @if (!$user->twofa_enabled)
                        <!-- Card Informasi -->
                        <div class="card" id="infoCard">
                            <div class="card-header">
                                <strong class="card-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Tentang 2FA
                                </strong>
                            </div>
                            <div class="card-body">
                                <h6><strong>Keunggulan 2FA:</strong></h6>
                                <ul class="text-sm">
                                    <li>🔒 Keamanan tambahan yang kuat</li>
                                    <li>📱 Akses cepat tanpa mengingat password</li>
                                    <li>🛡️ Perlindungan dari phishing 99%</li>
                                    <li>⚡ Kode segar setiap kali login</li>
                                </ul>

                                <h6 class="mt-3"><strong>Channel Tersedia:</strong></h6>
                                <div class="mt-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <div>
                                            <strong>Email</strong>
                                            <small class="text-muted d-block">Akses universal</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fab fa-telegram text-info me-2"></i>
                                        <div>
                                            <strong>Telegram</strong>
                                            <small class="text-muted d-block">Notifikasi real-time</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-warning mt-3">
                                    <small>
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <strong>Penting:</strong> 2FA adalah tambahan, bukan pengganti. Login normal tetap
                                        tersedia.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Card Bantuan -->
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">
                                    <i class="fas fa-question-circle me-2"></i>
                                    Butuh Bantuan?
                                </strong>
                            </div>
                            <div class="card-body">
                                <p class="text-sm">Jika mengalami kesulitan dalam setup atau verifikasi 2FA:</p>
                                <ul class="text-sm">
                                    <li>Pastikan koneksi internet stabil</li>
                                    <li>Cek folder spam untuk email 2FA</li>
                                    <li>Verifikasi Chat ID Telegram sudah benar</li>
                                    <li>Hubungi administrator jika masalah berlanjut</li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <!-- Card Status Keamanan -->
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <strong class="card-title">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Keamanan Terlindungi
                                </strong>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <i class="fas fa-shield-check fa-3x text-success"></i>
                                    <h5 class="mt-2 text-success">Akun Aman</h5>
                                </div>

                                <h6><strong>Keunggulan yang Aktif:</strong></h6>
                                <ul class="text-sm list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success mr-2"></i>
                                        <strong>Two-Factor Authentication</strong>
                                        <small class="d-block text-muted ml-4">Lapisan keamanan ganda</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success mr-2"></i>
                                        <strong>Login Tanpa Password</strong>
                                        <small class="d-block text-muted ml-4">Akses cepat dan aman</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success mr-2"></i>
                                        <strong>Anti-Phishing</strong>
                                        <small class="d-block text-muted ml-4">Perlindungan dari serangan</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success mr-2"></i>
                                        <strong>Kode Dinamis</strong>
                                        <small class="d-block text-muted ml-4">Keamanan berubah setiap login</small>
                                    </li>
                                </ul>

                                <div class="alert alert-info mt-3">
                                    <small>
                                        <i class="fas fa-lightbulb mr-1"></i>
                                        <strong>Tips:</strong> Bookmark halaman login 2FA untuk akses lebih cepat!
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Card Statistik Penggunaan -->
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">
                                    <i class="fas fa-chart-line me-2"></i>
                                    Statistik Keamanan
                                </strong>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-right">
                                            <h4 class="text-success">100%</h4>
                                            <small class="text-muted">Keamanan Aktif</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="text-primary">1</h4>
                                        <small class="text-muted">Channel Aktif</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endsection

        @push('scripts')
            <script nonce="{{ csp_nonce() }}">
                document.addEventListener("DOMContentLoaded", function(event) {
                    let countdownTimer;
                    let resendTimer;

                    // Toggle channel sections
                    $('input[name="method"]').change(function() {
                        if ($(this).val() === 'email') {
                            $('#emailSection').removeClass('d-none');
                            $('#telegramSection').addClass('d-none');
                        } else {
                            $('#emailSection').addClass('d-none');
                            $('#telegramSection').removeClass('d-none');
                        }
                    });

                    $('input[name="method"]').eq(0).trigger('change');

                    // Setup form submission
                    $(document).on('submit', '#twofaSetupForm', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const btn = $(this).find('button[type="submit"]');
                        const originalText = btn.html();
                        btn.prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim Kode...');

                        $.ajax({
                            url: '{{ route('2fa.setup') }}',
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function(response) {
                                updateWizardStep(2);
                                // Show verification step (pastikan elemen ada)
                                if ($('#step1Content').length && $('#step2Content').length) {
                                    $('#step1Content').addClass('d-none');
                                    $('#step2Content').removeClass('d-none');
                                }
                                if ($('#twofaSentMessage').length) {
                                    $('#twofaSentMessage').html(
                                        '<i class="fas fa-check-circle mr-2"></i>' + response
                                        .message);
                                }
                                setTimeout(() => {
                                    if ($('#twofaCode').length) $('#twofaCode').focus();
                                }, 500);
                                startCountdown({{ $twoFactorConfig['expires_minutes'] ?? 5 }} *
                                60); // expires in minutes converted to seconds
                                startResendCountdown(
                                {{ $twoFactorConfig['resend_seconds'] ?? 30 }}); // resend cooldown in seconds
                            },
                            error: function(xhr) {
                                console.log('AJAX Error:', xhr);
                                const response = xhr.responseJSON;
                                Swal.fire(
                                    'Error!',
                                    response?.message || 'Gagal mengirim kode aktivasi',
                                    'error'
                                );
                            },
                            complete: function() {
                                btn.prop('disabled', false).html(originalText);
                            }
                        });
                        return false;
                    });

                    // Verify form submission
                    $(document).on('submit', '#twofaVerifyForm', function(e) {
                        e.preventDefault();
                        const code = $('#twofaCode').val();
                        if (code.length !== {{ $twoFactorConfig['length'] ?? 6 }}) {
                            Swal.fire(
                                'Peringatan!',
                                'Kode 2FA harus {{ $twoFactorConfig['length'] ?? 6 }} digit',
                                'warning'
                            );
                            return false;
                        }
                        const btn = $(this).find('button[type="submit"]');
                        const originalText = btn.html();
                        btn.prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin mr-2"></i>Memverifikasi...');
                        $.ajax({
                            url: '{{ route('2fa.verify-activation') }}',
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function(response) {
                                // Clear any timers
                                clearInterval(countdownTimer);
                                clearInterval(resendTimer);

                                Swal.fire(
                                    'Berhasil!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    // Redirect to 2FA settings page
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    } else {
                                        // Fallback: reload the page
                                        window.location.reload();
                                    }
                                });
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON;
                                Swal.fire(
                                    'Error!',
                                    response.message || 'Verifikasi gagal',
                                    'error'
                                );
                                $('#twofaCode').val('').focus();
                            },
                            complete: function() {
                                btn.prop('disabled', false).html(originalText);
                            }
                        });
                        return false;
                    });

                    // Resend 2FA
                    $('#resendBtn').click(function() {
                        const btn = $(this);
                        const originalText = btn.html();

                        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...');

                        $.ajax({
                            url: '{{ route('2fa.resend') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Berhasil!',
                                    response.message,
                                    'success'
                                );
                                startResendCountdown({{ $twoFactorConfig['resend_seconds'] ?? 30 }});
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON;
                                Swal.fire(
                                    'Error!',
                                    response.message || 'Gagal mengirim ulang',
                                    'error'
                                );
                            },
                            complete: function() {
                                btn.html(originalText);
                            }
                        });
                    });

                    // Back to setup
                    $('#backToSetup').click(function() {
                        $('#step2Content').addClass('d-none');
                        $('#step1Content').removeClass('d-none');
                        updateWizardStep(1);
                        clearInterval(countdownTimer);
                        clearInterval(resendTimer);
                        $('#twofaCode').val('');
                    });

                    // Disable 2FA
                    $('#disableTwofaBtn').click(function() {
                        Swal.fire({
                            title: 'Nonaktifkan 2FA?',
                            html: `
                    <div class="text-left">
                        <p><strong>Anda akan kehilangan:</strong></p>
                        <ul class="text-sm">
                            <li>Lapisan keamanan tambahan (2FA)</li>
                            <li>Akses cepat tanpa password</li>
                            <li>Perlindungan dari serangan phishing</li>
                        </ul>
                        <p class="text-warning mt-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Apakah Anda yakin ingin melanjutkan?</strong>
                        </p>
                    </div>
                `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: '<i class="fas fa-times mr-2"></i>Ya, Nonaktifkan',
                            cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Batal',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const btn = $(this);
                                const originalText = btn.html();

                                btn.prop('disabled', true).html(
                                    '<i class="fas fa-spinner fa-spin mr-2"></i>Menonaktifkan...');

                                $.ajax({
                                    url: '{{ route('2fa.disable') }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            title: '2FA Dinonaktifkan!',
                                            text: response.message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            // Redirect to 2FA settings page
                                            if (response.redirect) {
                                                window.location.href = response
                                                .redirect;
                                            } else {
                                                // Fallback: reload the page
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: function(xhr) {
                                        const response = xhr.responseJSON;
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: response.message ||
                                                'Gagal menonaktifkan 2FA',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    },
                                    complete: function() {
                                        btn.prop('disabled', false).html(originalText);
                                    }
                                });
                            }
                        });
                    });

                    // Auto-focus and format 2FA input
                    $('#twofaCode').on('input', function() {
                        this.value = this.value.replace(/[^0-9]/g, '');
                        if (this.value.length === {{ $twoFactorConfig['length'] ?? 6 }}) {
                            $('#twofaVerifyForm').submit();
                        }
                    });

                    // Enhanced UI interactions for 2FA active state
                    $('.info-box').hover(
                        function() {
                            $(this).addClass('shadow');
                        },
                        function() {
                            $(this).removeClass('shadow');
                        }
                    );

                    function startCountdown(seconds) {
                        let timeLeft = seconds;
                        countdownTimer = setInterval(function() {
                            const minutes = Math.floor(timeLeft / 60);
                            const secs = timeLeft % 60;
                            $('#countdown').text(minutes + ':' + (secs < 10 ? '0' : '') + secs);

                            if (timeLeft <= 0) {
                                clearInterval(countdownTimer);
                                $('#countdown').text('Kedaluwarsa').addClass('text-danger');
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
                                $('#resendBtn').html('<i class="fas fa-redo mr-2"></i>Kirim Ulang');
                            }
                            timeLeft--;
                        }, 1000);
                    }

                    function updateWizardStep(step) {
                        if (step === 1) {
                            // Step 1: Setup
                            $('#step1').removeClass('completed').addClass('active');
                            $('#step2').removeClass('active completed');
                            $('#line1').removeClass('completed');
                            $('#stepTitle').text('Langkah 1: Pengaturan Channel');
                            $('#stepDesc').text('Pilih metode pengiriman kode 2FA');
                        } else if (step === 2) {
                            // Step 2: Verification
                            $('#step1').removeClass('active').addClass('completed');
                            $('#step2').addClass('active');
                            $('#line1').addClass('completed');
                            $('#stepTitle').text('Langkah 2: Verifikasi Kode');
                            $('#stepDesc').text('Masukkan kode aktivasi yang telah dikirim');
                        }
                    }
                });
            </script>
        @endpush

</x-app-layout>
