<!-- Modal -->
<div class="modal fade" id="detil-{{ $table .'-'. $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="staticBackdropLabel">Data SPPT Tangungan Rayon</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <livewire:master-data.rayon.info-detail :table="$table" :data="$data">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!--  Datatables -->
    @include('layouts.includes._scripts-datatable')

    <!--  Menampilkan Datatables -->
    <script type="text/javascript">
        $(document).ready( function () {
            $('#table-detail{{ $table }}-{{ $data->id }}').DataTable();
        });
    </script>
@endpush
