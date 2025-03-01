<div class="item form-group d-flex align-items-center mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="subjek_pajak_id">Nama dan Alamat Wajib Pajak <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 me-2">
        <select id="subjek_pajak_id" name="subjek_pajak_id" class="form-select select2  width-100 @error('subjek_pajak_id') is-invalid @enderror" autocomplete="off" required>
            <option value="" readonly>-- Pilih NIK, Nama dan Alamat Wajib Pajak --</option>
            @foreach ($subjeks as $item)
                <option value="{{ $item->id }}" {{ old('subjek_pajak_id', $sppt->subjek_pajak_id) == $item->id ? 'selected' : null}}>
                    NIK: {{ $item->nik .' - '. strtoupper($item->nama_subjek) .' - '. strtoupper($item->alamat_subjek) }}
                </option>
            @endforeach
        </select>
    </div>
    @error('subjek_pajak_id')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex align-items-center mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="pemilik">Nama dan Alamat Pemilik</label>
    <div class="col-md-6 col-sm-6 me-2">
        <select id="pemilik" name="pemilik" class="form-select select2 width-100 @error('pemilik') is-invalid @enderror" autocomplete="off">
            <option value="" readonly>-- Pilih NIK, Nama dan Alamat Pemilik --</option>
            @foreach ($subjeks as $item)
                <option value="{{ $item->id }}" {{ old('pemilik', $sppt->pemilik) == $item->id ? 'selected' : null}}>
                    NIK: {{ $item->nik .' - '. strtoupper($item->nama_subjek) .' - '. strtoupper($item->alamat_subjek) }}
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
        <input type="text" id="nilai_pagu_pajak" name="nilai_pagu_pajak" maxlength="10" max="9999999999" class="form-control" value="{{ old('nilai_pagu_pajak') ?? number_format($sppt->nilai_pagu_pajak, 0, "", "") }}">
    </div>
    @error('nilai_pagu_pajak')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="periode_id">Periode</label>
    <div class="col-md-6 col-sm-6 me-2">
        <select id="periode_id" name="periode_id" class="form-select select2 width-100 @error('periode_id') is-invalid @enderror" required autocomplete="off">
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
    <script nonce="{{ csp_nonce() }}">
        document.addEventListener("DOMContentLoaded", () => {
            $('input[name=nilai_pagu_pajak]').inputmask('numeric', {max: 9999999999})

            var elements = document.getElementsByTagName("SELECT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function (e) {
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        switch (e.srcElement.id) {
                            case "subjek_pajak_id":
                                e.target.setCustomValidity("silakan isi pilih dari daftar nama dan alamat wajib pajak !!!");
                                break;
                        }
                    }
                };
                elements[i].oninput = function (e) {
                    e.target.setCustomValidity("");
                };
            }
        })
    </script>
@endpush
