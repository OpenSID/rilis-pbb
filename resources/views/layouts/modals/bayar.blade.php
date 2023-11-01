<!-- Modal untuk bayar massal -->
<div class="modal fade text-start" id="bayar-sppt-massal" tabindex="-1" role="dialog" aria-labelledby="bayar-sppt-massal-label" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bayar-sppt-massal-label">Bayar SPPT Masal</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route($table.'.bayarMasal') }}" method="post">
                    @csrf

                    <div class="mb-4">
                        Apakah Anda yakin ingin melakukan pembayaran SPPT berikut ini ?
                    </div>
                    <div class="clear"></div>
                    <div class="content-table">

                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal">Tidak</button>
                        </div>
                        <div class="mx-1"></div>
                        <div>
                            <button type="submit" class="btn btn-success btn-block"> Ya</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
