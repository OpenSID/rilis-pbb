<div class="wizard-content" id="step1Content">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">
                <i class="fas fa-shield-alt mr-2"></i>
                Setup Autentikasi OTP
            </h3>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Informasi:</strong> OTP (One Time Password) akan menjadi alternatif login tambahan untuk
                meningkatkan keamanan akun Anda.
                Username dan password tetap dapat digunakan seperti biasa.
            </div>
            <form id="otpSetupForm">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold">Pilih Channel Pengiriman:</label>
                    <div class="mt-2">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="channelEmail" name="channel"
                                value="email" checked>
                            <label for="channelEmail" class="custom-control-label">
                                <i class="fas fa-envelope text-primary mr-2"></i>
                                <strong>Email</strong>
                                <small class="text-muted d-block">Kode OTP akan dikirim ke email Anda</small>
                            </label>
                        </div>
                        <div class="custom-control custom-radio mt-2">
                            <input class="custom-control-input" type="radio" id="channelTelegram" name="channel"
                                value="telegram">
                            <label for="channelTelegram" class="custom-control-label">
                                <i class="fab fa-telegram text-info mr-2"></i>
                                <strong>Telegram</strong>
                                <small class="text-muted d-block">Kode OTP akan dikirim melalui bot Telegram</small>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="emailSection" class="form-group">
                    <label for="emailInput">Email Address:</label>
                    <input type="email" class="form-control" id="emailInput" name="identifier"
                        value="{{ $user->email }}" placeholder="Masukkan email Anda">
                    <small class="form-text text-muted">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Pastikan email aktif dan dapat menerima pesan
                    </small>
                </div>
                <div id="telegramSection" class="form-group d-none">
                    <label for="telegramInput">Telegram Chat ID:</label>
                    <input type="text" class="form-control" id="telegramInput" name="telegram_identifier"
                        value="{{ $user->telegram_id }}" placeholder="Masukkan Telegram Chat ID">
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Hubungi bot @userinfobot dan ketik /start untuk mendapatkan Chat ID
                    </small><br>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Hubungi bot {{ env('TELEGRAM_BOT_NAME', 'belum diset') }} dan ketik /start agar bot telegram
                        dapat mengirim kode OTP ke Anda
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
