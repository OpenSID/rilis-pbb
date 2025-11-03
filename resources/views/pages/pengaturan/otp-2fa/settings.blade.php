<x-app-layout title="Konfigurasi OTP & 2FA">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Pengaturan" active="Konfigurasi OTP & 2FA"></x-breadcrumbs>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pages/pengaturan/otp.css') }}">
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-8">
                    <!-- Card Setup -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-primary">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Konfigurasi Keamanan OTP & 2FA
                            </h5>
                            <small>Atur metode pengiriman kode verifikasi</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-info border-0 bg-light-info">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-info-circle text-info mr-3 mt-1"></i>
                                    <div>
                                        <h6 class="text-info mb-1"><strong>Informasi Penting</strong></h6>
                                        <p class="mb-0">Konfigurasi ini akan digunakan untuk mengirim kode verifikasi OTP
                                            (One-Time Password) dan 2FA (Two-Factor Authentication). Anda cukup mengatur
                                            sekali dan dapat digunakan untuk kedua fitur keamanan.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- @if ($user->otp_channel && $user->otp_identifier)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <strong>Konfigurasi Saat Ini:</strong><br>
                                    Metode: <strong>{{ ucfirst(json_decode($user->otp_channel)[0] ?? '-') }}</strong><br>
                                    Identifier: <strong>{{ $user->otp_identifier }}</strong>
                                </div>
                            @endif --}}

                            <form id="configSetupForm">
                                @csrf
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-dark mb-3">
                                        <i class="fas fa-paper-plane text-primary mr-2"></i>
                                        Pilih Metode Pengiriman Kode Verifikasi
                                    </label>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card border method-card" data-method="email">
                                                <div class="card-body text-center p-3">
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="methodEmail"
                                                            name="method" value="email"
                                                            {{ old('method', json_decode($user->otp_channel)[0] ?? null) == 'email' ? 'checked' : '' }}>
                                                        <label for="methodEmail" class="custom-control-label w-100">
                                                            <div class="method-option">
                                                                <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                                                <h6 class="font-weight-bold mb-1">Email</h6>
                                                                <small class="text-muted">Kode dikirim ke alamat email
                                                                    Anda</small>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card border method-card" data-method="telegram">
                                                <div class="card-body text-center p-3">
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio"
                                                            id="methodTelegram" name="method" value="telegram"
                                                            {{ old('method', json_decode($user->otp_channel)[0] ?? null) == 'telegram' ? 'checked' : '' }}>
                                                        <label for="methodTelegram" class="custom-control-label w-100">
                                                            <div class="method-option">
                                                                <i class="fab fa-telegram fa-2x text-info mb-2"></i>
                                                                <h6 class="font-weight-bold mb-1">Telegram</h6>
                                                                <small class="text-muted">Kode dikirim via bot
                                                                    Telegram</small>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Section -->
                                <div id="emailSection" class="form-group">
                                    <div class="card bg-light border-left-primary">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-envelope text-primary mr-2"></i>
                                                <h6 class="mb-0 font-weight-bold">Alamat Email</h6>
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-at p-1"></i></span>
                                                </div>
                                                <input type="email" class="form-control" id="emailInput" name="contact"
                                                    value="{{ $user->email }}" readonly style="background-color: #f8f9fa;">
                                            </div>
                                            <small class="form-text text-muted mt-2">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Email diambil dari profil Anda. Untuk mengubah, silakan perbarui di
                                                <a href="{{ route('pengguna.edit', encrypt(Auth::user()->id)) }}"
                                                    class="text-primary">menu Pengguna</a>.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Telegram Section -->
                                <div id="telegramSection" class="form-group d-none">
                                    <div class="card bg-light border-left-info">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fab fa-telegram text-info mr-2"></i>
                                                <h6 class="mb-0 font-weight-bold">Telegram ID</h6>
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fab fa-telegram p-1"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="telegramInput"
                                                    name="telegram_contact"
                                                    value="{{ $user->telegram_id ?? 'Belum diatur' }}" readonly
                                                    style="background-color: #f8f9fa;">
                                            </div>
                                            <small class="form-text text-muted mt-2">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Telegram ID diambil dari profil Anda. Untuk mengubah, silakan perbarui di
                                                <a href="{{ route('pengguna.edit', encrypt(Auth::user()->id)) }}"
                                                    class="text-primary">menu Pengguna</a>.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                @if (empty($user->email))
                                    <div class="alert alert-warning border-0" id="emailWarning">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-exclamation-triangle text-warning mr-3 mt-1"></i>
                                            <div>
                                                <h6 class="text-warning mb-1"><strong>Perhatian!</strong></h6>
                                                <p class="mb-1">Email Anda belum diatur. Silakan lengkapi profil Anda
                                                    terlebih dahulu di menu Pengguna.</p>
                                                <a href="{{ route('pengguna.edit', encrypt(Auth::user()->id)) }}"
                                                    class="btn btn-sm btn-outline-warning mt-2">
                                                    <i class="fas fa-user-edit mr-1"></i> Update Profil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (empty($user->telegram_id))
                                    <div class="alert alert-warning border-0 d-none" id="telegramWarning">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-exclamation-triangle text-warning mr-3 mt-1"></i>
                                            <div>
                                                <h6 class="text-warning mb-1"><strong>Perhatian!</strong></h6>
                                                <p class="mb-1">Telegram ID Anda belum diatur. Silakan lengkapi profil
                                                    Anda terlebih dahulu di menu Pengguna.</p>
                                                <a href="{{ route('pengguna.edit', encrypt(Auth::user()->id)) }}""
                                                    class="btn btn-sm btn-outline-warning mt-2">
                                                    <i class="fas fa-user-edit mr-1"></i> Update Profil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group mt-4">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane mr-2"></i>
                                            Kirim Kode Verifikasi
                                        </button>
                                        <a href="{{ route('otp-2fa.index') }}" class="btn btn-outline-secondary btn-lg">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Kembali
                                        </a>
                                    </div>

                                    <div class="alert alert-light border mt-3 mb-0">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-lightbulb text-info mr-2 mt-1"></i>
                                            <small class="text-muted mb-0">
                                                <strong>Tips:</strong> Setelah mengirim kode, Anda akan diminta memasukkan 6
                                                digit kode verifikasi yang diterima untuk menyelesaikan konfigurasi
                                                keamanan.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Card Verification (Hidden by default) -->
                    <div class="card shadow-sm d-none" id="verificationCard">
                        <div class="card-header bg-gradient-success text-white">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-shield-check mr-2"></i>
                                Verifikasi Kode Keamanan
                            </h4>
                            <small class="text-white-50">Masukkan kode yang dikirim ke Anda</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-success border-0 bg-light-success" id="verificationMessage">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success mr-3 mt-1"></i>
                                    <div>
                                        <h6 class="text-success mb-1"><strong>Kode Berhasil Dikirim!</strong></h6>
                                        <p class="mb-0">Kode verifikasi telah dikirim. Silakan periksa email atau
                                            Telegram Anda.</p>
                                    </div>
                                </div>
                            </div>

                            <form id="verificationForm">
                                @csrf
                                <div class="form-group text-center">
                                    <label for="verificationCode" class="font-weight-bold text-dark mb-3">
                                        <i class="fas fa-key text-warning mr-2"></i>
                                        Masukkan Kode Verifikasi 6 Digit
                                    </label>

                                    <div class="verification-input-container mb-3">
                                        <input type="text"
                                            class="form-control form-control-lg text-center verification-input"
                                            id="verificationCode" name="code" placeholder="• • • • • •"
                                            maxlength="6" required
                                            style="font-size: 1.5rem; letter-spacing: 0.5rem; font-weight: bold;">
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="countdown-container">
                                            <i class="fas fa-clock text-warning mr-2"></i>
                                            <span class="text-muted">Kode akan kadaluarsa dalam </span>
                                            <span class="badge badge-success font-weight-bold" id="countdown">05:00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <div class="btn-group-vertical btn-group-lg w-100 mb-3">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Verifikasi & Simpan Konfigurasi
                                        </button>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <button type="button" class="btn btn-outline-info" id="resendBtn" disabled>
                                            <i class="fas fa-redo mr-2"></i>
                                            Kirim Ulang (<span id="resendCountdown">30</span>s)
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" id="backToSetup">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Kembali ke Setup
                                        </button>
                                    </div>

                                    <div class="alert alert-light border mt-3 mb-0">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            <strong>Catatan:</strong> Pastikan kode yang dimasukkan benar dan sesuai dengan
                                            yang Anda terima.
                                        </small>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Card Informasi -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-shield-alt text-primary mr-2"></i>
                                Tentang Keamanan OTP & 2FA
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="text-primary font-weight-bold mb-2">
                                    <i class="fas fa-star text-warning mr-1"></i>
                                    Keunggulan Fitur:
                                </h6>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item border-0 px-0 py-2">
                                        <i class="fas fa-lock text-success mr-2"></i>
                                        <small>Satu konfigurasi untuk OTP & 2FA</small>
                                    </div>
                                    <div class="list-group-item border-0 px-0 py-2">
                                        <i class="fas fa-envelope text-primary mr-2"></i>
                                        <small>Dukungan email dan Telegram</small>
                                    </div>
                                    <div class="list-group-item border-0 px-0 py-2">
                                        <i class="fas fa-bolt text-warning mr-2"></i>
                                        <small>Proses setup yang mudah & cepat</small>
                                    </div>
                                    <div class="list-group-item border-0 px-0 py-2">
                                        <i class="fas fa-shield-check text-info mr-2"></i>
                                        <small>Keamanan akun berlapis</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-info font-weight-bold mb-2">
                                    <i class="fas fa-paper-plane text-info mr-1"></i>
                                    Metode Pengiriman:
                                </h6>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="text-center p-2 border rounded">
                                            <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                            <div>
                                                <strong class="d-block">Email</strong>
                                                <small class="text-muted">Instan & Aman</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center p-2 border rounded">
                                            <i class="fab fa-telegram fa-2x text-info mb-2"></i>
                                            <div>
                                                <strong class="d-block">Telegram</strong>
                                                <small class="text-muted">Real-time</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning border-0">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-circle text-warning mr-2 mt-1"></i>
                                    <small class="mb-0">
                                        <strong>Penting:</strong> Pastikan informasi kontak Anda benar dan dapat diakses
                                        untuk menerima kode verifikasi.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Bantuan -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-life-ring text-info mr-2"></i>
                                Bantuan & Tips
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-dark font-weight-bold mb-2">
                                    <i class="fas fa-tools text-warning mr-1"></i>
                                    Troubleshooting:
                                </h6>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item border-0 px-0 py-1">
                                        <i class="fas fa-wifi text-success mr-2"></i>
                                        <small>Pastikan koneksi internet stabil</small>
                                    </div>
                                    <div class="list-group-item border-0 px-0 py-1">
                                        <i class="fas fa-search text-primary mr-2"></i>
                                        <small>Cek folder spam/junk untuk email</small>
                                    </div>
                                    <div class="list-group-item border-0 px-0 py-1">
                                        <i class="fab fa-telegram text-info mr-2"></i>
                                        <small>Pastikan bot Telegram aktif</small>
                                    </div>
                                    <div class="list-group-item border-0 px-0 py-1">
                                        <i class="fas fa-id-card text-warning mr-2"></i>
                                        <small>Verifikasi Chat ID Telegram</small>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info border-0">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-lightbulb text-info mr-2 mt-1"></i>
                                    <small class="mb-0">
                                        <strong>Tips:</strong> Kode verifikasi berlaku selama 5 menit. Jika tidak diterima
                                        dalam 1 menit, periksa koneksi atau coba kirim ulang.
                                    </small>
                                </div>
                            </div>


                        </div>
                    </div>
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

                // Initialize method card interactions
                initializeMethodCardInteractions();

                function initializeMethodSelection() {
                    // Try multiple approaches to ensure the selection works
                    var selectedMethod = $('input[name="method"]:checked');

                    if (selectedMethod.length > 0) {
                        // Trigger change event for the already selected method
                        selectedMethod.trigger('change');
                    } else {
                        // If no method is selected, default to email
                        $('#methodEmail').prop('checked', true).trigger('change');
                    }
                }

                function initializeMethodCardInteractions() {
                    // Handle method card click
                    $('.method-card').on('click', function() {
                        var method = $(this).data('method');
                        var radioInput = $('#method' + method.charAt(0).toUpperCase() + method.slice(1));

                        // Update radio button
                        radioInput.prop('checked', true).trigger('change');
                    });

                    // Handle verification code input formatting
                    $('#verificationCode').on('input', function() {
                        var value = $(this).val().replace(/[^0-9]/g, '');
                        $(this).val(value);

                        // Visual feedback
                        if (value.length > 0) {
                            $(this).removeClass('border-danger').addClass('border-success');
                        } else {
                            $(this).removeClass('border-success border-danger');
                        }

                        // Auto-submit when 6 digits entered
                        if (value.length === 6) {
                            $(this).addClass('border-success');
                            // Show loading state
                            $(this).addClass('loading');

                            // Add small delay for better UX
                            setTimeout(function() {
                                $('#verificationForm').submit();
                            }, 800);
                        }
                    });

                    // Handle paste event for verification code
                    $('#verificationCode').on('paste', function(e) {
                        setTimeout(function() {
                            var pastedValue = $('#verificationCode').val().replace(/[^0-9]/g, '')
                                .substring(0, 6);
                            $('#verificationCode').val(pastedValue);

                            if (pastedValue.length === 6) {
                                $('#verificationCode').addClass('border-success loading');
                                setTimeout(function() {
                                    $('#verificationForm').submit();
                                }, 500);
                            }
                        }, 10);
                    });
                }

                // Also listen for potential DOM changes
                window.addEventListener('load', function() {
                    setTimeout(initializeMethodSelection, 100);
                });

                // Handle method change with delegated event binding
                $(document).on('change', 'input[name="method"]', function() {
                    var selectedMethod = $(this).val();

                    // Update card visual states
                    $('.method-card').removeClass('active');
                    $(this).closest('.method-card').addClass('active');

                    if (selectedMethod === 'email') {
                        $('#emailSection').removeClass('d-none');
                        $('#telegramSection').addClass('d-none');
                        $('#telegramWarning').removeClass('d-block').addClass('d-none');
                        $('#emailWarning').removeClass('d-none');
                        $('#emailInput').attr('name', 'contact');
                        $('#telegramInput').removeAttr('name');
                    } else {
                        $('#emailSection').addClass('d-none');
                        $('#telegramSection').removeClass('d-none');
                        $('#emailWarning').addClass('d-none');
                        @if (empty($user->telegram_id))
                            $('#telegramWarning').removeClass('d-none').addClass('d-block');
                        @endif
                        $('#telegramInput').attr('name', 'contact');
                        $('#emailInput').removeAttr('name');
                    }
                });

                // Handle form submission for setup
                $('#configSetupForm').submit(function(e) {
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

                    // Validate based on selected method
                    if (selectedMethod === 'email') {
                        @if (empty($user->email))
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Email Anda belum diatur. Silakan lengkapi profil Anda terlebih dahulu di menu Pengguna.'
                            });
                            return;
                        @endif
                    } else if (selectedMethod === 'telegram') {
                        @if (empty($user->telegram_id))
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Telegram ID Anda belum diatur. Silakan lengkapi profil Anda terlebih dahulu di menu Pengguna.'
                            });
                            return;
                        @endif
                    }

                    var formData = $(this).serialize();

                    $.ajax({
                        url: "{{ route('otp-2fa.setup') }}",
                        method: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#configSetupForm button[type="submit"]').prop('disabled', true)
                                .html('<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...');
                        },
                        success: function(response) {
                            if (response.success) {
                                // Show verification card
                                $('#verificationCard').removeClass('d-none');
                                $('#verificationMessage').html(
                                    '<i class="fas fa-check-circle mr-2"></i> ' + response
                                    .message
                                );

                                // Hide setup form
                                $('#configSetupForm').closest('.card').addClass('d-none');

                                // Start countdown
                                startCountdown();

                                // Scroll to verification card
                                $('html, body').animate({
                                    scrollTop: $('#verificationCard').offset().top - 100
                                }, 500);
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
                            $('#configSetupForm button[type="submit"]').prop('disabled', false)
                                .html(
                                    '<i class="fas fa-paper-plane mr-2"></i> Kirim Kode Verifikasi'
                                );
                        }
                    });
                });

                // Handle verification form submission
                $('#verificationForm').submit(function(e) {
                    e.preventDefault();

                    // Prevent multiple submissions
                    if ($(this).data('submitting')) {
                        return false;
                    }

                    var formData = $(this).serialize();
                    var submitBtn = $(this).find('button[type="submit"]');

                    // Set submitting flag
                    $(this).data('submitting', true);

                    $.ajax({
                        url: "{{ route('otp-2fa.verify') }}",
                        method: 'POST',
                        data: formData,
                        beforeSend: function() {
                            submitBtn.prop('disabled', true)
                                .html(
                                    '<i class="fas fa-spinner fa-spin mr-2"></i> Memverifikasi...');
                        },
                        success: function(response) {
                            if (response.success) {
                                // Clear any existing timers
                                if (window.countdownInterval) clearInterval(window
                                    .countdownInterval);
                                if (window.resendInterval) clearInterval(window.resendInterval);

                                // Show success alert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then(() => {
                                    window.location.href = "{{ route('otp-2fa.index') }}";
                                });
                            } else {
                                // Reset submitting flag on failure
                                $('#verificationForm').data('submitting', false);

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Verifikasi Gagal',
                                    text: response.message
                                });

                                // Clear the code input
                                $('#verificationCode').val('');
                            }
                        },
                        error: function(xhr) {
                            // Reset submitting flag on error
                            $('#verificationForm').data('submitting', false);

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
                            $('#verificationCode').val('');
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false)
                                .html('<i class="fas fa-check mr-2"></i> Verifikasi & Simpan');
                        }
                    });
                });

                // Handle resend button
                $('#resendBtn').click(function() {
                    if ($(this).prop('disabled')) return;

                    $.ajax({
                        url: "{{ route('otp-2fa.resend') }}",
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
                                $('#verificationMessage').html(
                                    '<div class="d-flex align-items-start">' +
                                    '<i class="fas fa-check-circle text-success mr-3 mt-1"></i>' +
                                    '<div>' +
                                    '<h6 class="text-success mb-1"><strong>Kode Berhasil Dikirim Ulang!</strong></h6>' +
                                    '<p class="mb-0">' + response.message + '</p>' +
                                    '</div>' +
                                    '</div>'
                                );
                                startCountdown();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Kode verifikasi telah dikirim ulang',
                                    timer: 2000,
                                    showConfirmButton: false
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
                            // Keep button disabled until countdown finishes
                        }
                    });
                });

                // Handle back to setup button
                $('#backToSetup').click(function() {
                    $('#verificationCard').addClass('d-none');
                    $('#configSetupForm').closest('.card').removeClass('d-none');
                    $('#verificationCode').val('');

                    // Scroll to setup form
                    $('html, body').animate({
                        scrollTop: $('#configSetupForm').offset().top - 100
                    }, 500);
                });

                // Countdown functions
                function startCountdown() {
                    var countdownTime = {{ config('app.otp_token_expires_minutes', 5) }} * 60;
                    var resendTime = {{ config('app.otp_resend_decay_seconds', 30) }};

                    // Clear any existing intervals
                    if (window.countdownInterval) clearInterval(window.countdownInterval);
                    if (window.resendInterval) clearInterval(window.resendInterval);

                    // Update main countdown with visual enhancements
                    window.countdownInterval = setInterval(function() {
                        var minutes = Math.floor(countdownTime / 60);
                        var seconds = countdownTime % 60;
                        var timeDisplay = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

                        $('#countdown').text(timeDisplay);

                        // Change color based on time remaining
                        if (countdownTime <= 60) {
                            $('#countdown').removeClass('badge-warning').addClass('badge-danger');
                        } else if (countdownTime <= 120) {
                            $('#countdown').removeClass('badge-warning badge-danger').addClass('badge-warning');
                        }

                        if (countdownTime <= 0) {
                            clearInterval(window.countdownInterval);
                            $('#verificationCode').prop('disabled', true).addClass('bg-light');
                            $('#countdown').text('Kadaluarsa').removeClass('badge-warning badge-danger')
                                .addClass('badge-secondary');

                            Swal.fire({
                                icon: 'warning',
                                title: 'Kode Kadaluarsa',
                                text: 'Kode verifikasi telah kadaluarsa. Silakan kirim ulang kode baru.',
                                confirmButtonText: 'Kirim Ulang',
                                showCancelButton: true,
                                cancelButtonText: 'Kembali ke Setup'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#resendBtn').click();
                                } else {
                                    $('#backToSetup').click();
                                }
                            });
                        }

                        countdownTime--;
                    }, 1000);

                    // Update resend button countdown with better UX
                    window.resendInterval = setInterval(function() {
                        $('#resendCountdown').text(resendTime);

                        if (resendTime <= 0) {
                            clearInterval(window.resendInterval);
                            $('#resendBtn').prop('disabled', false)
                                .removeClass('btn-outline-info')
                                .addClass('btn-info')
                                .html('<i class="fas fa-redo mr-2"></i> Kirim Ulang');
                        } else {
                            $('#resendBtn').html('<i class="fas fa-clock mr-2"></i> Tunggu (' + resendTime +
                                's)');
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
