<div class="mt-2">
    @if (session()->has('message-success'))
    <div class="text-center alert alert-success">
        {{ session('message-success') }}
    </div>
    @elseif(session()->has('message-failed'))
    <div class="text-center alert alert-danger">
        {{ session('message-failed') }}
    </div>
    @endif
    

    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i>
        Jika Anda belum memiliki token OpenSID, klik tombol "Dapatkan Token OpenSID" di bawah untuk mendapatkannya dari API OpenSID.
    </div>

    @if ($opensid_token)
    <button wire:click="updateTokenPremium()" type="button" class="btn btn-danger w-100 mb-2"><i class="fa fa-gear"></i>
        Update Token Layanan Premium OpenSID</button>
    @endif

    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#tokenModal"><i class="fa fa-key"></i>
        Dapatkan Token OpenSID</button>
</div>

<!-- Modal untuk mendapatkan token -->
<div class="modal fade" wire:ignore.self id="tokenModal" aria-hidden="true" aria-labelledby="tokenModalLabel" tabindex="-2">
    <livewire:pengaturan.modal-token :aplikasi="$aplikasi">
</div>

@push('scripts')
<script nonce="{{ csp_nonce() }}">
    document.addEventListener("DOMContentLoaded", () => {
        window.addEventListener('refresh-page', function() {
            location.reload(); // reload halaman penuh
        });
    });
</script>
@endpush