<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="alamat_subjek">Alamat Subjek Pajak </label>
    <div class="col-md-6 col-sm-6">
        <input type="text" id="alamat_subjek" name="alamat_subjek" class="form-control" value="{{ old('alamat_subjek') ?? $subjek->alamat_subjek }}">
    </div>
    @error('alamat_subjek')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="npwp">NPWP</label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="npwp" name="npwp" class="form-control" value="{{ old('npwp') ?? $subjek->npwp }}">
    </div>
    @error('npwp')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="no_hp">Nomor HP
    </label>
    <div class="col-md-6 col-sm-6 me-2">
        <input type="number" id="no_hp" name="no_hp" oninput="maxLengthCheck(this)" maxlength="16" max="9999999999999999" class="form-control" value="{{ old('no_hp') ?? $subjek->no_hp }}">
    </div>
    @error('no_hp')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<hr>

<div class="item form-group text-end">
    <div class="col-md-12 col-sm-12 d-flex justify-content-end">
        <button class="btn btn-primary me-2" type="reset"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $reset .' '. ucwords(str_replace('-', ' ', $table )) }}">
            {{ $reset }}
        </button>
        <button type="submit" class="btn btn-success"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $submit .' '. ucwords(str_replace('-', ' ', $table )) }}">
            {{ $submit }}
        </button>
    </div>
</div>

@push('scripts')
    @include('layouts.includes._scripts-validation')
@endpush
