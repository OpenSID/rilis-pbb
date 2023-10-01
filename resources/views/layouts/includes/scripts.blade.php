<script type="module" nonce="{{ csp_nonce() }}" src="{{asset('/build/assets/app-a6a58541.js')}}"></script>
<!-- Livewire -->
@livewireScripts(['nonce' => csp_nonce()])


<!-- Pesan Sukses -->
@include('layouts.includes._scripts-alert')

<!-- Skrip pada halaman tertentu -->
@stack('scripts')

<!-- lokal -->
<script nonce="{{ csp_nonce() }}">
    /** Start Modal Filter */
    window.addEventListener('closeModalObjekPajakDetail', event => {
        $("#modal-detail-objek").modal('hide');
    })

    window.addEventListener('openModalObjekPajakDetail', event => {
        $("#modal-detail-objek").modal('show');
    })
</script>
