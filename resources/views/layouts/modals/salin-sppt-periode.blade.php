<!-- Modal untuk hapus 1 data -->
<div class="modal fade text-start" id="salinSemuaPeriode-{{ $table }}" tabindex="-1" role="dialog" aria-labelledby="salinSemuaPeriode-{{ $table }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salinSemuaPeriode-{{ $table }}Label">Salin Data SPPT</h5>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    Apakah Anda yakin ingin salin Data SPPT berdasarkan tahun yang dipilih ke tahun {{ date('Y') }} ?
                </div>
                <div class="clear"></div>

                <form action="{{ route($table. '.salinPeriode') }}" method="post">
                    @csrf
                    <div class="col-md-12 col-sm-12">
                        <select id="salin_periode" name="salin_periode" class="form-select @error('salin_periode') is-invalid @enderror" autocomplete="off" style="width: 100%;"  aria-label="Default select example">
                            <option value="" readonly>-- Pilih Tahun --</option>
                            @foreach ($periodes as $index => $item)
                                @if($index > 0)
                                    <option value="{{ $item->id }}">
                                        {{ $item->tahun }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @error('salin_periode')
                        <div class="text-danger mt-1 d-block">{{ $message }}</div>
                    @enderror
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger btn-block"><i class="fa fa-trash"></i>  Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
