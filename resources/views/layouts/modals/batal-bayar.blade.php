<!-- Modal untuk hapus 1 data -->
<div class="modal fade text-start" id="{{ $table .'-'. $data->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $table .'-'. $data->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $table .'-'. $data->id }}Label">Batal Bayar SPPT</h5>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    Apakah Anda yakin ingin membatalkan pembayaran SPPT ini ?
                </div>
                <div class="clear"></div>

                <div class="d-flex justify-content-between">
                    <div>
                        <br>
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tidak</button>
                    </div>
                    <div class="mx-1"></div>
                    <div>
                        <form action="{{ route($table.'.destroy', encrypt($data->id)) }}" method="post">
                            @csrf
                            @method("DELETE")
                            <br>
                            <button type="submit" class="btn btn-danger btn-block"><i class="fa fa-trash"></i>  Ya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
