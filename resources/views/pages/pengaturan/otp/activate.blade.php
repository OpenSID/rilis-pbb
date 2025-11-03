<x-app-layout title="Aktivasi OTP">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Pengaturan" active="OTP"></x-breadcrumbs>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pages/pengaturan/otp.css') }}">
    @endsection
@section('content')
    <div class="animated fadeIn">
    <div class="row">
        <div class="col-md-8">
            @if(!$user->hasOtpEnabled())
                <!-- Wizard Container -->
                <div id="otpWizard">
                    <!-- Wizard Progress -->
                    <div class="card mb-3" id="wizardProgress">
                        <div class="card-body p-3">
                            <div class="row">                                
                                <div class="text-center mb-3">
                                    <div class="step-info">
                                        <strong id="stepTitle">Langkah 1: Pengaturan Channel</strong>
                                        <small class="text-muted d-block" id="stepDesc">Pilih metode pengiriman kode OTP</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('pages.pengaturan.otp.step1')
                    @include('pages.pengaturan.otp.step2')
                </div>
                @include('pages.pengaturan.otp.success')
            @else
                <!-- Status OTP Aktif -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <strong class="card-title">
                            <i class="fas fa-shield-check me-2"></i>
                            Status OTP: <span class="badge bg-primary text-white ms-2">AKTIF</span>
                        </strong>
                    </div>
                    <div class="card-body">                      
                        <!-- Informasi Detail OTP -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="info-box">
                                    <h6 class="text-primary"><i class="fas fa-broadcast-tower me-2"></i><strong>Channel Aktif:</strong></h6>
                                    <div class="mt-2">
                                        @foreach($user->getOtpChannels() as $channel)
                                            <span class="badge badge-primary badge-lg me-2 mb-1">
                                                    @if($channel === 'email')
                                                        <i class="fas fa-envelope me-1"></i> Email
                                                    @else
                                                        <i class="fab fa-telegram me-1"></i> Telegram
                                                    @endif
                                                </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <h6 class="text-primary"><i class="fas fa-id-card me-2"></i><strong>Identifier:</strong></h6>
                                    <div class="mt-2">
                                        <code class="bg-light p-2 rounded">{{ $user->otp_identifier }}</code>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <h6 class="text-primary"><i class="fas fa-calendar-check me-2"></i><strong>Status:</strong></h6>
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
                                    <h6 class="text-info mb-2"><i class="fas fa-shield-alt mr-2"></i>Status Keamanan</h6>
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
                                <h6 class="text-primary"><i class="fas fa-question-circle me-2"></i><strong>Cara Menggunakan OTP:</strong></h6>
                            <ol class="text-sm pl-3">
                                <li>Di halaman login, pilih <strong>"Login dengan OTP"</strong></li>
                                <li>Masukkan identifier Anda: <code>{{ $user->otp_identifier }}</code></li>
                                <li>Kode OTP akan dikirim ke channel yang aktif</li>
                                <li>Masukkan kode 6 digit untuk masuk ke sistem</li>
                            </ol>
                        </div>

                        <!-- Tombol Aksi -->
                                    <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                    OTP adalah tambahan keamanan, login normal tetap tersedia
                                </small>
                            </div>
                            <div>
                                            <button type="button" class="btn btn-outline-warning" id="disableOtpBtn">
                                                <i class="fas fa-times-circle me-2"></i>
                                    Nonaktifkan OTP
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            @if(!$user->hasOtpEnabled())
            <!-- Card Informasi -->
                <div class="card" id="infoCard">
                    <div class="card-header">
                        <strong class="card-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Tentang OTP
                        </strong>
                    </div>
                <div class="card-body">
                    <h6><strong>Keunggulan OTP:</strong></h6>
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
                            <strong>Penting:</strong> OTP adalah tambahan, bukan pengganti. Login normal tetap tersedia.
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
                    <p class="text-sm">Jika mengalami kesulitan dalam setup atau verifikasi OTP:</p>
                    <ul class="text-sm">
                        <li>Pastikan koneksi internet stabil</li>
                        <li>Cek folder spam untuk email OTP</li>
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
                                <strong>Tips:</strong> Bookmark halaman login OTP untuk akses lebih cepat!
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
                                <h4 class="text-primary">{{ count($user->getOtpChannels()) }}</h4>
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
<script nonce="{{  csp_nonce() }}">
document.addEventListener("DOMContentLoaded", function (event) {
    let countdownTimer;
    let resendTimer;

    // Toggle channel sections
    $('input[name="channel"]').change(function() {
        if ($(this).val() === 'email') {
            $('#emailSection').removeClass('d-none');
            $('#telegramSection').addClass('d-none');
            $('#emailInput').attr('name', 'identifier');
            $('#telegramInput').removeAttr('name');
        } else {
            $('#emailSection').addClass('d-none');
            $('#telegramSection').removeClass('d-none');
            $('#telegramInput').attr('name', 'identifier');
            $('#emailInput').removeAttr('name');
        }
    });

    $('input[name="channel"]').eq(0).trigger('change');     

    // Setup form submission
    $(document).on('submit', '#otpSetupForm', function(e) {        
        e.preventDefault();
        e.stopPropagation();
        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim Kode...');
        
        $.ajax({
            url: '{{ route("otp.setup") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {                
                updateWizardStep(2);
                // Show verification step (pastikan elemen ada)
                if ($('#step1Content').length && $('#step2Content').length) {                    
                    $('#step1Content').addClass('d-none');
                    $('#step2Content').removeClass('d-none');
                }
                if ($('#otpSentMessage').length) {
                    $('#otpSentMessage').html('<i class="fas fa-check-circle mr-2"></i>' + response.message);
                }
                setTimeout(() => {
                    if ($('#otpCode').length) $('#otpCode').focus();
                }, 500);
                startCountdown(window.otpConfig.expiresMinutes * 60); // expires in minutes converted to seconds
                startResendCountdown(window.otpConfig.resendSeconds); // resend cooldown in seconds
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
    $(document).on('submit', '#otpVerifyForm', function(e) {
        e.preventDefault();
        const otp = $('#otpCode').val();
        if (otp.length !== 6) {
            Swal.fire(
                'Peringatan!',
                'Kode OTP harus 6 digit',
                'warning'
            );
            return false;
        }
        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Memverifikasi...');
        $.ajax({
            url: '{{ route("otp.verify-activation") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Hide wizard and info card, show success card
                $('#otpWizard').addClass('d-none');
                $('#infoCard').addClass('d-none');
                setTimeout(() => {
                    $('#successCard').removeClass('d-none');
                }, 300);
                // Clear any timers
                clearInterval(countdownTimer);
                clearInterval(resendTimer);
                Swal.fire(
                    'Berhasil!',
                    response.message,
                    'success'
                );
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                Swal.fire(
                    'Error!',
                    response.message || 'Verifikasi gagal',
                    'error'
                );
                $('#otpCode').val('').focus();
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
        return false;
    });

    // Resend OTP
    $('#resendBtn').click(function() {
        const btn = $(this);
        const originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...');

        $.ajax({
            url: '{{ route("otp.resend") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                Swal.fire(
                    'Berhasil!',
                    response.message,
                    'success'
                );
                startResendCountdown(window.otpConfig.resendSeconds);
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
        $('#otpCode').val('');
    });

    // Disable OTP
    $('#disableOtpBtn').click(function() {
        Swal.fire({
            title: 'Nonaktifkan OTP?',
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
                
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menonaktifkan...');

                $.ajax({
                    url: '{{ route("otp.disable") }}',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        Swal.fire({
                            title: 'OTP Dinonaktifkan!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message || 'Gagal menonaktifkan OTP',
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

    // Auto-focus and format OTP input
    $('#otpCode').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length === 6) {
            $('#otpVerifyForm').submit();
        }
    });

    // Enhanced UI interactions for OTP active state
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
            $('#stepDesc').text('Pilih metode pengiriman kode OTP');
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