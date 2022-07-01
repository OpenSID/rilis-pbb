<div class="item form-group d-flex align-items-center mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_rayon">Nama Rayon <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="nama_rayon" name="nama_rayon" required="required" class="form-control" value="{{ old('nama_rayon') ?? $data->nama_rayon }}">
    </div>
    @error('nama_rayon')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<hr>

<div class="item form-group">
    <div class="col-md-12 col-sm-12 text-end">
        <button class="btn btn-primary" type="reset">{{ $reset }}</button>
        <button type="submit" class="btn btn-success">{{ $submit }}</button>
    </div>
</div>

