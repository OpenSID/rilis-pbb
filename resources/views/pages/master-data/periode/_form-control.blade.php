<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="tahun">Tahun Pajak <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 me-2">
        <input type="text" id="tahun" name="tahun" required="required" maxlength="4" class="form-control" value="{{ old('tahun') ?? $data->tahun }}">
    </div>
    @error('tahun')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<hr>

<div class="item form-group">
    <div class="col-md-12 col-sm-12 text-end">
        <button class="btn btn-primary" type="reset"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $reset .' '. ucwords(str_replace('-', ' ', $table )) }}">
            {{ $reset }}
        </button>
        <button type="submit" class="btn btn-success"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $submit .' '. ucwords(str_replace('-', ' ', $table )) }}">
            {{ $submit }}
        </button>
    </div>
</div>

