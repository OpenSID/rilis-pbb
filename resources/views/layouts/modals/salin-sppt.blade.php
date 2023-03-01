<!-- Modal untuk hapus 1 data -->
<div class="modal fade text-start" id="salin-{{ $table .'-'. $data->id }}" tabindex="-1" role="dialog" aria-labelledby="salin-{{ $table .'-'. $data->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salin-{{ $table .'-'. $data->id }}Label">Salin Data SPPT</h5>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    Apakah Anda yakin ingin salin Data SPPT ini ?
                </div>
                <div class="clear"></div>
                <form action="{{ route($table.'.salin', encrypt($data->id)) }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-4"><span>NOP</span></div>
                        <div class="col-md-1"><span>:</span></div>
                        <div class="col-md-6"><span>{{ $data->nop }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><span>Nama Wajib Pajak</span></div>
                        <div class="col-md-1"><span>:</span></div>
                        <div class="col-md-6"><span>{{ $data->subjek_pajak->nama_subjek }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><span>Pagu Pajak</span></div>
                        <div class="col-md-1"><span>:</span></div>
                        <div class="col-md-6"><span>Rp {{ $data->nilai_pagu_pajak == 0 ? '-' : number_format($data->nilai_pagu_pajak, 0, ".", ".") }},-</span></div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger btn-block"><i class="fa fa-trash"></i>  Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
