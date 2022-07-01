<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="letak_objek">Letak Objek Pajak<span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 me-2">
        <input type="text" id="letak_objek" name="letak_objek" required="required" class="form-control" value="{{ old('letak_objek') ?? $objek->letak_objek }}">
    </div>
    @error('letak_objek')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="kode_blok">Kode Blok
        <span class="required">*
            <i class="fa fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Digit ke 11 sampai 13 Pada NOP (contoh: 010)."></i>
        </span>
    </label>
    <div class="col-md-6 col-sm-6 me-2">
        <input type="number" id="kode_blok" name="kode_blok" required="required" maxlength="3" class="form-control" value="{{ old('kode_blok') ?? $objek->kode_blok }}">
    </div>
    @error('kode_blok')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="rt_id">RT (Rukun Tetangga)</label>
    <div class="col-md-6 col-sm-6 me-2">
        <select id="rt_id" name="rt_id" class="form-select select2 @error('rt_id') is-invalid @enderror" autocomplete="off">
            <option value="">-- Pilih RT --</option>
            @foreach ($rts as $item)
                <option value="{{ $item->id }}" {{ old('rt_id', $objek->rt_id) == $item->id ? 'selected' : null}}>
                    {{ $item->nama_rt .' | ' .($item->rayon->nama_rayon ?? '')}}
                </option>
            @endforeach
        </select>
    </div>
    @error('rt_id')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="alamat_objek">Alamat Objek Pajak <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 me-2">
        <input type="text" id="alamat_objek" name="alamat_objek" required="required" class="form-control" value="{{ $objek->alamat_objek ?? $desa.', '.$kecamatan.', '.$kabupaten }}">
    </div>
    @error('alamat_objek')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<hr>

<livewire:master-data.objek-pajak.table-detail :data="$objek" :table="$table">

<hr>

<div class="item form-group {{ ($submit == 'Tambah' ? 'text-end' : 'text-end') }}">
    <div class="col-md-12 col-sm-12">
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

@push('scripts')
    <script>
        $('#luas_objek_pajak').removeAttr('required');
        $('#klas').removeAttr('required');
        $('#njop').removeAttr('required');
        $('#total_njop').removeAttr('required');
    </script>
@endpush
