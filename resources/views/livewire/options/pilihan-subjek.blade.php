<div>
    @if(session()->has('message-failed'))
        <div class="text-center alert alert-danger">
            {{ session('message-failed') }}
        </div>
    @endif
    <div class="item form-group d-flex align-items-center mb-2">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="kategori">Kategori</label>
        <div class="col-md-6 col-sm-6">
            <select wire:model="selectedKategori" id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" autocomplete="off">
                <option value="" readonly>-- Pilih Kategori --</option>
                @foreach ($options as $item)
                    <option value="{{ $item['value'] }}" {{ old('kategori', $subjek->kategori) == $item['value'] ? 'selected' : null}}>
                        {{ $item['label'] }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('kategori')
            <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="{{ $showOptions == true ? 'd-inline' : 'd-none' }}">
        <div wire:ignore>
            @include('pages.master-data.subjek-pajak._data-penduduk')
        </div>
    </div>

    <div class="item form-group d-flex mb-2 {{ $showOptions == true ? 'd-inline' : 'd-none' }}">
        <label class="col-form-label col-md-3 col-sm-3 label-align d-none" for="penduduk">Penduduk</span></label>
        <div class="col-md-6 col-sm-6 ">
            <input type="hidden" wire:model="penduduk" id="penduduk" name="penduduk" class="form-control" value="{{ old('penduduk') ?? $subjek->penduduk }}">
        </div>
        @error('penduduk')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="item form-group d-flex mb-2 {{ $showInput == true ? 'd-inline' : 'd-none' }}">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nik">NIK
        </label>
        <div class="col-md-6 col-sm-6 me-2">
            <input type="number" wire:model="nik" id="nik" name="nik" oninput="maxLengthCheck(this)" maxlength="16" max="9999999999999999" class="form-control" value="{{ old('nik') ?? $subjek->nik }}">
        </div>
        @error('nik')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="item form-group d-flex mb-2 {{ $showInput == true ? 'd-inline' : 'd-none' }}">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_subjek">Nama Subjek Pajak<span class="{{ $showInput == null ? 'required' : '' }}">*</span></label>
        <div class="col-md-6 col-sm-6 ">
            <input type="text" wire:model="nama_subjek" id="nama_subjek" name="nama_subjek" class="form-control" {{ $showInput == true ? 'required' : '' }} value="{{ old('nama_subjek') ?? $subjek->nama_subjek }}">
        </div>
        @error('nama_subjek')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            var elements = document.getElementsByTagName("INPUT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function (e) {
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        switch (e.srcElement.id) {
                            case "nama_subjek":
                                e.target.setCustomValidity("silakan isi nama subjek pajak !!!");
                                break;
                        }
                    }
                };
                elements[i].oninput = function (e) {
                    e.target.setCustomValidity("");
                };
            }

            $('#nama_subjek').on('change', function() {
                var nilai = this.value;
                var subjek = nilai.split(" - ");
                $("input#penduduk").val(subjek['0']);
                $("input#nama_subjek").val(subjek['1']);
                $("input#nik").val(subjek['2']);
            });
        });
    </script>
@endpush
