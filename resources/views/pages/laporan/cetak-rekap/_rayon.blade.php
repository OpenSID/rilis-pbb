<div class="item form-group mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="rayon_id">{{ ucwords(str_replace('-', ' ', $aplikasi['sebutan_rayon'] )) }}</label>
    <div class="col-md-12 col-sm-12">
        <select name="rayon_id" id="rayon_id" wire:model="selectedRayon" required="required" class="form-select " data-width="100%">
            <option value=''>-- Pilih {{ ucwords(str_replace('-', ' ', $aplikasi['sebutan_rayon'] )) }}--</option>
            @foreach($rayons as $rayon)
                <option value="{{ $rayon->id }}" >{{ $rayon->nama_rayon}}</option>
            @endforeach
        </select>
    </div>
    @error('rayon_id')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>
