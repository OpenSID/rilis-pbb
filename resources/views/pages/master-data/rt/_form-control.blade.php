<div class="item form-group d-flex align-items-center mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="rayon_id">Nama {{ ucwords(str_replace('-', ' ', $aplikasi['sebutan_rayon'] )) }} <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6">
        <select id="rayon_id" name="rayon_id" class="form-select select2 @error('rayon_id') is-invalid @enderror" autocomplete="off">
            <option value=''> -- Pilih {{ ucwords(str_replace('-', ' ', $aplikasi['sebutan_rayon'] )) }} -- </option>
            @foreach($rayons as $item)
                <option value="{{ $item->id }}" {{ old('rayon_id', $data->rayon_id) == $item->id ? 'selected' : null}}>
                    {{ $item->nama_rayon }}
                </option>
            @endforeach
        </select>
    </div>
    @error('rayon_id')
        <div class="text-danger ms-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex align-items-center mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_rt">Nama RT <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="nama_rt" name="nama_rt" class="form-control" value="{{ old('nama_rt') ?? $data->nama_rt }}">
    </div>
    @error('nama_rt')
    <div class="text-danger ms-1 d-block">{{ $message }}</div>
    @enderror
</div>

<hr>

<div class="item form-group">
    <div class="col-md-12 col-sm-12 d-flex justify-content-end">
        <button class="btn btn-primary me-2" type="reset">{{ $reset }}</button>
        <button type="submit" class="btn btn-success">{{ $submit }}</button>
    </div>
</div>

