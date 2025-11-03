<div class="wizard-content d-none" id="step2Content">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h3 class="card-title">
                <i class="fas fa-check-circle mr-2"></i>
                Verifikasi Kode Aktivasi
            </h3>
        </div>
        <div class="card-body">
            <div class="alert alert-success" id="otpSentMessage"></div>
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Langkah Terakhir:</strong> Masukkan kode 6 digit yang telah dikirim untuk menyelesaikan aktivasi OTP.
            </div>
            <form id="otpVerifyForm">
                @csrf
                <div class="form-group">
                    <label for="otpCode" class="font-weight-bold">Masukkan Kode Aktivasi:</label>
                    <input type="tel" class="form-control form-control-lg text-center otp-input" id="otpCode" name="otp" pattern="{{ '[0-9]{' . ($otpConfig['length'] ?? 6) . '}' }}" maxlength="{{ $otpConfig['length'] ?? 6 }}" placeholder="{{ str_repeat('0', $otpConfig['length'] ?? 6) }}">
                    <small class="form-text text-muted text-center">
                        Kode berlaku selama <span id="countdown">{{ $otpConfig['expires_minutes'] ?? 5 }}:00</span> menit
                    </small>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-sm mr-2">
                        <i class="fas fa-check mr-2"></i>
                        Verifikasi & Aktifkan
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="resendBtn" disabled>
                        <i class="fas fa-redo mr-2"></i>
                        Kirim Ulang (<span id="resendCountdown">{{ $otpConfig['resend_seconds'] ?? 30 }}</span>s)
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