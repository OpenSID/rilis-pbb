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

    @if ($opensid_token)
        <button wire:click="updateTokenPremium()" type="button" class="btn btn-danger w-100"><i class="fa fa-gear"></i>
            Update Token Layanan Premium OpenSID</button>
    @endif
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
