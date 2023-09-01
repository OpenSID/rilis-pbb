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
                        <div class="col-md-4 mb-2"><span>NOP</span></div>
                        <div class="col-md-1"><span>:</span></div>
                        <div class="col-md-6"><span class="data-nop">{{ $data?->nop ?? '' }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2"><span>Nama Wajib Pajak</span></div>
                        <div class="col-md-1"><span>:</span></div>
                        <div class="col-md-6"><span class="data-nama_subjek">{{ $data?->subjek_pajak?->nama_subjek ?? '' }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><span>Pagu Pajak</span></div>
                        <div class="col-md-1"><span>:</span></div>
                        <div class="col-md-6">
                            <input type="text" id="nilai_pagu_pajak" name="nilai_pagu_pajak" maxlength="10" max="9999999999" class="form-control" value="{{ old('nilai_pagu_pajak') ?? number_format($data?->nilai_pagu_pajak ?? 0, 0, "", "") }}">
                       </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-info btn-block"><i class="fa fa-clone text-white"></i>  <span class="text-white"> Ya </span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

