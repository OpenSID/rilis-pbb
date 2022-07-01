<!-- Modal untuk hapus 1 data -->
<div class="modal fade text-start" id="setor-{{ $table .'-'. $data->tanggal_bayar }}" tabindex="-1" role="dialog" aria-labelledby="{{ $table .'-'. $data->tanggal_bayar }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="{{ $table .'-'. $data->tanggal_bayar }}Label">Rekap Waktu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route($table.'.update', $data->tanggal_bayar) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="item form-group mb-3">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="tanggal_setor">Tanggal Setor</label>
                        <div class="col-md-12 col-sm-12">
                            <input class="form-control" type="date" name="tanggal_setor" id="tanggal_setor" required/>
                        </div>
                        @error('tanggal_setor')
                        <div class="text-danger mt-1 d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-success-detail btn-block" style="float: right">Setor</button>
                </form>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
