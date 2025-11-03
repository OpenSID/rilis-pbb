<x-app-layout title="Pengaturan 2FA">

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
                                                            name="method" value="email"
                                                            @php
$channels = !empty($user->otp_channel) ? json_decode($user->otp_channel, true) : [];
                                                        $currentMethod = is_array($channels) && count($channels) > 0 ? $channels[0] : ''; @endphp
                                                            {{ old('method', $currentMethod) == 'email' ? 'checked' : '' }}>
                                                        <label for="methodEmail" class="custom-control-label">
                                                            <i class="fas fa-envelope text-primary mr-2"></i>
                                                            <strong>Email</strong>
                                                            <small class="text-muted d-block">Kode 2FA akan dikirim ke email
                                                                Anda</small>
                                                        </label>
                                                    </div>
                                                    <div class="custom-control custom-radio mt-2">
                                                        <input class="custom-control-input" type="radio"
                                                            id="methodTelegram" name="method" value="telegram"
                                                            {{ old('method', $currentMethod) == 'telegram' ? 'checked' : '' }}>
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
                                                    value="{{ old('contact', $user->otp_identifier) ?: $user->email }}"
                                                    placeholder="Masukkan email Anda">
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Pastikan email aktif dan dapat menerima pesan
                                                </small>
                                            </div>
                                            <div id="telegramSection" class="form-group d-none">
                                                <label for="telegramInput">Telegram Chat ID:</label>
                                                <input type="text" class="form-control" id="telegramInput"
                                                    name="telegram_contact"
                                                    value="{{ old('contact', $user->otp_identifier) ?: $user->telegram_id }}"
                                                    placeholder="Masukkan Telegram Chat ID">
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Hubungi bot @userinfobot dan ketik /start untuk mendapatkan Chat ID
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
                                                <span class="badge bg-primary bg-lg py-1 mb-1">
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
                                    <li>Pastikan Telegram bot dapat mengirim pesan</li>
                                    <li>Periksa kembali Chat ID Telegram</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script nonce="{{ csp_nonce() }}">
            document.addEventListener("DOMContentLoaded", function(event) {
                // Check if jQuery is loaded
                if (typeof jQuery === 'undefined') {
                    console.error('jQuery is not loaded. Please check your script imports.');
                    return;
                }

                // Alias jQuery to $ for easier usage
                var $ = jQuery;

                // Initialize method selection when DOM is ready
                initializeMethodSelection();

                function initializeMethodSelection() {
                    // Try multiple approaches to ensure the selection works
                    var selectedMethod = $('input[name="method"]:checked');

                    if (selectedMethod.length > 0) {
                        // Trigger change event for the already selected method
                        selectedMethod.trigger('change');
                    } else {
                        // If no method is selected, default to email
                        console.log('No method selected, defaulting to email'); // Debug log
                        $('#methodEmail').prop('checked', true).trigger('change');
                    }
                }

                // Also listen for potential DOM changes
                window.addEventListener('load', function() {
                    setTimeout(initializeMethodSelection, 100);
                });

                // Handle method change with delegated event binding
                $(document).on('change', 'input[name="method"]', function() {
                    var selectedMethod = $(this).val();
                    if (selectedMethod === 'email') {
                        $('#emailSection').removeClass('d-none');
                        $('#telegramSection').addClass('d-none');
                        $('#emailInput').attr('name', 'contact');
                        $('#telegramInput').removeAttr('name');
                        // Set the value to user's email if available
                        if (!$('#emailInput').val() && typeof user !== 'undefined' && user.email) {
                            $('#emailInput').val(user.email);
                        }
                    } else {
                        $('#emailSection').addClass('d-none');
                        $('#telegramSection').removeClass('d-none');
                        // Set the value to user's telegram_id if available
                        if (!$('#telegramInput').val() && typeof user !== 'undefined' && user.telegram_id) {
                            $('#telegramInput').val(user.telegram_id);
                        }
                        $('#telegramInput').attr('name', 'contact');
                        $('#emailInput').removeAttr('name');
                    }
                });

                // Handle form submission for setup
                $('#twofaSetupForm').submit(function(e) {
                    e.preventDefault();

                    // Validate that a method is selected
                    var selectedMethod = $('input[name="method"]:checked').val();
                    if (!selectedMethod) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Silakan pilih metode pengiriman terlebih dahulu.'
                        });
                        return;
                    }

                    // Validate that the contact field is filled
                    var contactValue = $('input[name="contact"]').val();
                    if (!contactValue || contactValue.trim() === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Silakan isi ' + (selectedMethod === 'email' ? 'alamat email' :
                                'Telegram Chat ID') + ' terlebih dahulu.'
                        });
                        return;
                    }

                    // Additional validation for email format if email method is selected
                    if (selectedMethod === 'email' && !isValidEmail(contactValue)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Format alamat email tidak valid.'
                        });
                        return;
                    }

                    console.log('Form data to be submitted:', $(this).serialize()); // Debug log

                    var formData = $(this).serialize();

                    $.ajax({
                        url: "{{ route('2fa.setup') }}",
                        method: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#twofaSetupForm button[type="submit"]').prop('disabled', true)
                                .html('<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...');
                        },
                        success: function(response) {
                            if (response.success) {
                                // Show success message
                                $('#twofaSentMessage').html(
                                    '<i class="fas fa-check-circle mr-2"></i> ' + response
                                    .message);

                                // Switch to verification step
                                $('#step1Content').addClass('d-none');
                                $('#step2Content').removeClass('d-none');

                                // Start countdown
                                startCountdown();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            var errorMessage = 'Terjadi kesalahan saat menyimpan pengaturan';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: errorMessage
                            });
                        },
                        complete: function() {
                            $('#twofaSetupForm button[type="submit"]').prop('disabled', false)
                                .html(
                                    '<i class="fas fa-paper-plane mr-2"></i> Kirim Kode Aktivasi');
                        }
                    });
                });

                // Handle verification form submission
                $('#twofaVerifyForm').submit(function(e) {
                    e.preventDefault();

                    var formData = $(this).serialize();
                    var submitBtn = $(this).find('button[type="submit"]');

                    $.ajax({
                        url: "{{ route('2fa.verify-activation') }}",
                        method: 'POST',
                        data: formData,
                        beforeSend: function() {
                            submitBtn.prop('disabled', true)
                                .html(
                                    '<i class="fas fa-spinner fa-spin mr-2"></i> Memverifikasi...');
                        },
                        success: function(response) {
                            if (response.success) {
                                // Show success alert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(() => {
                                    // Redirect to 2FA settings page
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    } else {
                                        // Fallback: reload the page
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Verifikasi Gagal',
                                    text: response.message
                                });

                                // Clear the code input
                                $('#twofaCode').val('');
                            }
                        },
                        error: function(xhr) {
                            var errorMessage = 'Terjadi kesalahan saat memverifikasi kode';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Verifikasi Gagal',
                                text: errorMessage
                            });

                            // Clear the code input
                            $('#twofaCode').val('');
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false)
                                .html('<i class="fas fa-check mr-2"></i> Verifikasi & Aktifkan');
                        }
                    });
                });

                // Handle resend button
                $('#resendBtn').click(function() {
                    if ($(this).prop('disabled')) return;

                    $.ajax({
                        url: "{{ route('2fa.resend') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function() {
                            $('#resendBtn').prop('disabled', true)
                                .html('<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...');
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#twofaSentMessage').html(
                                    '<i class="fas fa-check-circle mr-2"></i> ' + response
                                    .message);
                                startCountdown();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            var errorMessage = 'Terjadi kesalahan saat mengirim ulang kode';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: errorMessage
                            });
                        },
                        complete: function() {
                            $('#resendBtn').prop('disabled', false)
                                .html(
                                    '<i class="fas fa-redo mr-2"></i> Kirim Ulang (<span id="resendCountdown">{{ $twoFactorConfig['resend_seconds'] ?? 30 }}</span>s)'
                                );
                        }
                    });
                });

                // Handle back to setup button
                $('#backToSetup').click(function() {
                    $('#step2Content').addClass('d-none');
                    $('#step1Content').removeClass('d-none');
                });

                // Handle disable 2FA
                $('#disableTwofaBtn').click(function() {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menonaktifkan 2FA?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Nonaktifkan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('2fa.disable') }}",
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                beforeSend: function() {
                                    $('#disableTwofaBtn').prop('disabled', true)
                                        .html(
                                            '<i class="fas fa-spinner fa-spin mr-2"></i> Menonaktifkan...'
                                        );
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: response.message
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: response.message
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    var errorMessage =
                                        'Terjadi kesalahan saat menonaktifkan 2FA';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: errorMessage
                                    });
                                },
                                complete: function() {
                                    $('#disableTwofaBtn').prop('disabled', false)
                                        .html(
                                            '<i class="fas fa-times-circle me-2"></i> Nonaktifkan 2FA'
                                        );
                                }
                            });
                        }
                    });
                });

                // Countdown functions
                function startCountdown() {
                    var countdownTime = {{ $twoFactorConfig['expires_minutes'] ?? 5 }} * 60;
                    var resendTime = {{ $twoFactorConfig['resend_seconds'] ?? 30 }};

                    // Update main countdown
                    var countdownInterval = setInterval(function() {
                        var minutes = Math.floor(countdownTime / 60);
                        var seconds = countdownTime % 60;
                        $('#countdown').text(('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2));

                        if (countdownTime <= 0) {
                            clearInterval(countdownInterval);
                            $('#twofaCode').prop('disabled', true);
                        }

                        countdownTime--;
                    }, 1000);

                    // Update resend button countdown
                    var resendInterval = setInterval(function() {
                        $('#resendCountdown').text(resendTime);
                        $('#resendBtn').prop('disabled', true);

                        if (resendTime <= 0) {
                            clearInterval(resendInterval);
                            $('#resendBtn').prop('disabled', false);
                            $('#resendCountdown').text('{{ $twoFactorConfig['resend_seconds'] ?? 30 }}');
                        }

                        resendTime--;
                    }, 1000);
                }

                // Email validation function
                function isValidEmail(email) {
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);
                }
            });
        </script>
    @endpush

</x-app-layout>
