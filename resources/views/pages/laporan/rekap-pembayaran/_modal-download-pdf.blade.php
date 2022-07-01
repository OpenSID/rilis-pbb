<!-- Modal untuk hapus 1 data -->
<div class="modal fade text-start" id="downoload-{{ $table }}" tabindex="-1" role="dialog" aria-labelledby="{{ $table }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="{{ $table }}Label">Laporan {{ ucwords(str_replace('-', ' ', $table )) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <livewire:options.pilihan-rt :table="$table">
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
