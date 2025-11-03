<x-app-layout title="Verifikasi Aktivasi 2FA">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Pengaturan,OTP & 2FA" active="Verifikasi 2FA"></x-breadcrumbs>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pages/pengaturan/otp.css') }}">
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">
                                <i class="fas fa-shield-alt me-2"></i>
                                Verifikasi Aktivasi 2FA
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" id="verificationMessage">
                                <i class="fas fa-check-circle me-2"></i>
                                Kode verifikasi telah dikirim ke <strong>{{ $maskedIdentifier }}</strong>
                            </div>

                            <form id="verificationForm" method="POST"
                                action="{{ route('2fa.verify-activate-with-config') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="code">Masukkan Kode Verifikasi:</label>
                                    <input type="text" class="form-control form-control-lg text-center" id="code"
                                        name="code" placeholder="000000" maxlength="6" required autofocus>
                                    <small class="form-text text-muted">
                                        Kode akan kadaluarsa dalam <strong><span id="countdown">05:00</span></strong>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check me-2"></i>Verifikasi & Aktifkan 2FA
                                    </button>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-secondary btn-block" id="resendBtn">
                                        <i class="fas fa-redo me-2"></i>Kirim Ulang (<span id="resendCountdown">30</span>s)
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ route('otp-2fa.index') }}" class="btn btn-link">
                                        <i class="fas fa-arrow-left me-1"></i>Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script nonce="{{ csp_nonce() }}">
            document.addEventListener('DOMContentLoaded', function() {
                let countdownInterval, resendInterval;

                // Start countdown
                startCountdown();

                function startCountdown() {
                    // Clear existing intervals
                    if (countdownInterval) clearInterval(countdownInterval);
                    if (resendInterval) clearInterval(resendInterval);

                    let countdownTime = {{ $config['expires_minutes'] ?? 5 }} * 60;
                    let resendTime = {{ $config['resend_seconds'] ?? 30 }};

                    // Main countdown
                    countdownInterval = setInterval(function() {
                        const minutes = Math.floor(countdownTime / 60);
                        const seconds = countdownTime % 60;
                        document.getElementById('countdown').textContent =
                            ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

                        if (countdownTime <= 0) {
                            clearInterval(countdownInterval);
                            document.getElementById('code').disabled = true;
                            alert('Kode verifikasi telah kadaluarsa. Silakan kirim ulang.');
                        }

                        countdownTime--;
                    }, 1000);

                    // Resend countdown
                    resendInterval = setInterval(function() {
                        document.getElementById('resendCountdown').textContent = resendTime;
                        document.getElementById('resendBtn').disabled = true;

                        if (resendTime <= 0) {
                            clearInterval(resendInterval);
                            document.getElementById('resendBtn').disabled = false;
                        }

                        resendTime--;
                    }, 1000);
                }

                // Handle form submission
                document.getElementById('verificationForm').addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memverifikasi...';
                });

                // Handle resend
                document.getElementById('resendBtn').addEventListener('click', function() {
                    if (this.disabled) return;

                    const btn = this;
                    const originalHtml = btn.innerHTML;

                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

                    fetch('{{ route('2fa.activate-with-config') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).then(r => r.json()).then(resp => {
                        if (resp.success) {
                            document.getElementById('verificationMessage').innerHTML =
                                '<i class="fas fa-check-circle me-2"></i>' + resp.message;
                            startCountdown();

                            // Show success notification
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Kode verifikasi telah dikirim ulang',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                alert('Kode verifikasi telah dikirim ulang');
                            }
                        } else {
                            alert(resp.message || 'Gagal mengirim ulang kode');
                        }
                    }).catch(() => {
                        alert('Gagal menghubungi server');
                    }).finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    });
                });
            });
        </script>
    @endpush

</x-app-layout>
