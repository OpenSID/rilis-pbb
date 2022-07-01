<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_subjek">Nama Subjek Pajak<span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="nama_subjek" name="nama_subjek" required="required" class="form-control" value="{{ old('nama_subjek') ?? $subjek->nama_subjek }}">
    </div>
    @error('nama_subjek')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

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
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="kategori">Kategori</label>
    <div class="col-md-6 col-sm-6">
        <select class="form-select" id="kategori" name="kategori" class="form-control @error('kategori') is-invalid @enderror" autocomplete="off">
            <option value="" disabled>-- Pilih --</option>
            @foreach ($options as $item)
                <option value="{{ $item['value'] }}" {{ old('kategori', $subjek->kategori) == $item['value'] ? 'selected' : null}}>
                    {{ $item['label'] }}
                </option>
            @endforeach
        </select>
    </div>
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
