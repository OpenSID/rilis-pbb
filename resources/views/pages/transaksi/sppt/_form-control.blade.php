<div class="item form-group d-flex align-items-center mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="subjek_pajak_id">Nama dan Alamat Wajib Pajak</label>
    <div class="col-md-6 col-sm-6 me-2">
        <select id="subjek_pajak_id" name="subjek_pajak_id" class="form-select select2 @error('subjek_pajak_id') is-invalid @enderror" autocomplete="off">
            <option value="" readonly>-- Pilih Nama dan Alamat Wajib Pajak --</option>
            @foreach ($subjeks as $item)
                <option value="{{ $item->id }}" {{ old('subjek_pajak_id', $sppt->subjek_pajak_id) == $item->id ? 'selected' : null}}>
                    {{ $item->nama_subjek .' - '. $item->alamat_subjek }}
                </option>
            @endforeach
        </select>
    </div>
    @error('subjek_pajak_id')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nilai_pagu_pajak">Pagu Pajak</label>
    <div class="col-md-6 col-sm-6">
        <input type="number" id="nilai_pagu_pajak" name="nilai_pagu_pajak" oninput="maxLengthCheck(this)" maxlength="10" max="9999999999" class="form-control" value="{{ old('nilai_pagu_pajak') ?? number_format($sppt->nilai_pagu_pajak, 0, "", "") }}">
    </div>
    @error('nilai_pagu_pajak')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="periode_id">Periode</label>
    <div class="col-md-6 col-sm-6 me-2">
        <select id="periode_id" name="periode_id" class="form-select select2 @error('periode_id') is-invalid @enderror" autocomplete="off">
            <option value="" readonly>-- Pilih Periode --</option>
            @foreach ($periodes as $item)
                <option value="{{ $item->id }}" {{ old('periode_id', $sppt->periode_id) == $item->id ? 'selected' : null}}>
                    {{ $item->tahun }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<hr>

<div class="item form-group text-end">
    <div class="col-md-12 col-sm-12">
        <button class="btn btn-primary" type="reset"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $reset .' '. strtoupper($table) }}">
            {{ $reset }}
        </button>

        <button type="submit" class="btn btn-success"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $submit .' '. strtoupper($table) }}">
            {{ $submit }}
        </button>
    </div>
</div>

@push('scripts')
    @include('layouts.includes._scripts-validation')
@endpush
