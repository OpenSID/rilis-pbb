<div class="card d-none" id="successCard">
    <div class="card-header bg-success text-white">
        <h3 class="card-title">
            <i class="fas fa-check-circle mr-2"></i>
            OTP Berhasil Diaktifkan!
        </h3>
    </div>
    <div class="card-body text-center">
        <div class="mb-4">
            <i class="fas fa-shield-check text-success" style="font-size: 72px;"></i>
        </div>
        <h4 class="text-success mb-3">Selamat!</h4>
        <p class="lead">Fitur OTP telah berhasil diaktifkan di akun Anda.</p>
        <div class="alert alert-info mt-4">
            <h6><strong>Langkah Selanjutnya:</strong></h6>
            <p class="mb-0">Anda sekarang dapat menggunakan login OTP sebagai alternatif yang lebih aman. Silakan logout dan coba fitur "Login dengan OTP" di halaman login.</p>
        </div>
        <div class="mt-4">
            <a href="{{ url('/admin') }}" class="btn btn-primary btn-sm mr-2">
                <i class="fas fa-home mr-2"></i>
                Ke Dashboard
            </a>            
        </div>
    </div>
</div>