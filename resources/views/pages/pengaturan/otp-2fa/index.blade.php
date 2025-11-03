<x-app-layout title="Pengaturan OTP & 2FA">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Pengaturan" active="OTP & 2FA"></x-breadcrumbs>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pages/pengaturan/otp.css') }}">
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title mb-0">Pengaturan OTP & 2FA</h4>
                                    <small class="text-muted">Pengaturan dan status OTP serta Two-Factor
                                        Authentication.</small>
                                </div>
                                <div>
                                    <a href="{{ route('otp-2fa.settings') }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-cogs me-1"></i> Atur Email / Telegram
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="text-primary mb-3">Status Konfigurasi</h6>
                            <div class="mb-3">
                                @php
                                    $chan = $user->otp_channel ?? null;
                                    $channels = [];

                                    if ($chan) {
                                        // If it's already an array (casted), use it
                                        if (is_array($chan)) {
                                            $channels = $chan;
                                        } else {
                                            // Try to json decode (handles strings like '["telegram"]'), fallback to single string
                                            $decoded = json_decode($chan, true);
                                            if (is_array($decoded)) {
                                                $channels = $decoded;
                                            } else {
                                                $channels = [trim($chan)];
                                            }
                                        }
                                    }

                                    // Normalize and remove empty values
                                    $channels = array_filter($channels, function ($c) {
                                        return $c !== null && $c !== '';
                                    });

                                    $display = $channels
                                        ? implode(
                                            ', ',
                                            array_map(function ($c) {
                                                return ucfirst($c);
                                            }, $channels),
                                        )
                                        : '-';
                                @endphp

                                <p><strong>Metode verifikasi:</strong> {{ $display }}</p>
                                <p><strong>Identifier:</strong>
                                    {{ $user->otp_identifier ?? '-' }}</p>

                                <p>
                                    <strong>Status Verifikasi:</strong>
                                    @if ($user->verified)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Belum Terverifikasi
                                        </span>
                                    @endif
                                </p>

                                @if (!$user->verified)
                                    <div class="alert alert-warning">
                                        Anda belum melakukan verifikasi. Silakan klik tombol "Atur Email / Telegram"
                                        untuk memverifikasi akun Anda.
                                    </div>
                                @endif
                            </div>

                            <hr>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3"><i class="fas fa-lock me-2"></i>One-Time Password (OTP)
                                    </h6>
                                    @if ($user->hasOtpEnabled())
                                        <p><span class="badge bg-success">AKTIF</span></p>
                                        <div class="mt-2">
                                            <button id="otpDisableBtn" class="btn btn-outline-warning btn-sm">Nonaktifkan
                                                OTP</button>
                                        </div>
                                    @else
                                        <p><span class="badge bg-secondary">TIDAK AKTIF</span></p>
                                        <div class="mt-2">
                                            <form action="{{ route('otp.activate') }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-check-circle me-1"></i> Aktifkan OTP
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3"><i class="fas fa-shield-alt me-2"></i>Two-Factor
                                        Authentication (2FA)</h6>
                                    @if ($user->twofa_enabled)
                                        <p><span class="badge bg-success">AKTIF</span></p>
                                        <div class="mt-2">
                                            <button id="twofaDisableBtn" class="btn btn-outline-warning btn-sm">Nonaktifkan
                                                2FA</button>
                                        </div>
                                    @else
                                        <p><span class="badge bg-secondary">TIDAK AKTIF</span></p>
                                        <div class="mt-2">
                                            <form action="{{ route('2fa.activate-with-config') }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-check-circle me-1"></i> Aktifkan 2FA
                                                </button>
                                            </form>
                                        </div>
                                    @endif
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
            document.addEventListener('DOMContentLoaded', function() {
                // Disable OTP
                document.getElementById('otpDisableBtn')?.addEventListener('click', function() {
                    if (!confirm('Nonaktifkan OTP untuk akun ini?')) return;

                    const btn = this;
                    btn.disabled = true;

                    fetch('{{ route('otp.disable') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).then(r => r.json()).then(resp => {
                        if (resp.success) {
                            alert(resp.message || 'OTP dinonaktifkan');
                            location.reload();
                        } else {
                            alert(resp.message || 'Gagal menonaktifkan OTP');
                            btn.disabled = false;
                        }
                    }).catch(() => {
                        alert('Gagal menghubungi server');
                        btn.disabled = false;
                    });
                });

                // Disable 2FA
                document.getElementById('twofaDisableBtn')?.addEventListener('click', function() {
                    if (!confirm('Nonaktifkan 2FA untuk akun ini?')) return;

                    const btn = this;
                    btn.disabled = true;

                    fetch('{{ route('2fa.disable') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).then(r => r.json()).then(resp => {
                        if (resp.success) {
                            alert(resp.message || '2FA dinonaktifkan');
                            location.reload();
                        } else {
                            alert(resp.message || 'Gagal menonaktifkan 2FA');
                            btn.disabled = false;
                        }
                    }).catch(() => {
                        alert('Gagal menghubungi server');
                        btn.disabled = false;
                    });
                });
            });
        </script>
    @endpush

</x-app-layout>
