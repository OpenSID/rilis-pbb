<!-- Modal untuk hapus beberapa data -->
<div class="modal fade text-start" id="importExcel-{{ $table }}" tabindex="-1" role="dialog" aria-labelledby="importExcel-{{ $table }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importExcel-{{ $table }}Label">Impor data {{ strtoupper($table) }} dari excel</h5>
            </div>
            <form action="{{ route($table.'.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Catatan: </strong>
                        <hr>
                        <ul class="m-2">
                            <li><a href="{{asset('/import/template/'.$table.'.xlsx')}}"><span class="text-primary">Unduh Format Excel.</span></a></li>
                            @foreach ($catatan as $item)
                                <li>{{ $item['keterangan'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group">
                        <input type="file" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
