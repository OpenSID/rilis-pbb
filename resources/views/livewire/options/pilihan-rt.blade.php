<div>
    <div class="item form-group mb-2">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="rayon_id">Rayon</label>
        <div class="col-md-12 col-sm-12">
            <select name="rayon_id" id="rayon_id" wire:model="selectedRayon" required="required" class="form-select " data-width="100%">
                <option value=''>-- Pilih Rayon --</option>
                @foreach($rayons as $rayon)
                    <option value="{{ $rayon->id }}" >{{ $rayon->nama_rayon}}</option>
                @endforeach
            </select>
        </div>
        @error('rayon_id')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @enderror
    </div>
    {{-- @if($selectedRayon > 0) --}}
    <div class="item form-group mb-2">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="rt_id">RT </label>
        <div class="col-md-12 col-sm-12">
            <select name="rt_id" id="rt_id" wire:model="selectedRT" required="required" class="form-select " data-width="100%">
                <option value=''>-- Pilih RT --</option>
                @foreach($rts as $rt)
                    <option value="{{ $rt->id }}" >{{ $rt->nama_rt}}</option>
                @endforeach
            </select>
        </div>
        @error('rt_id')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @enderror
    </div>

    <hr class="mt-4">
    <a wire:click="klikTombolCetak()" href="{{ route($table.'.downloadPdf', encrypt($idRt)) }}" target="_blank" class="btn btn-primary btn-block {{ $tombolCetak }}" style="float: right"
    data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Laporan">
        Cetak
    </a>
</div>
