<div>
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

    <div class="item form-group d-flex mb-2 {{ $showOptions == true ? 'd-inline' : 'd-none' }}">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_subjek">Nama Subjek Pajak<span class="{{ $opensids == null ? '' : 'required' }}">*</span></label>
        <div class="col-md-6 col-sm-6 me-2">
            <select wire:model="selectedSubjek" id="nama_subjek" name="nama_subjek" class="form-select @error('nama_subjek') is-invalid @enderror" autocomplete="off">
                <option value="" readonly>-- Pilih Nama Subjek Pajak --</option>
                @if(!is_null($opensids))
                    @foreach ($opensids as $index => $item)
                        @if($index > $totalpages)
                            <option value="{{ $opensids[$index]['id'] . ' - ' . $opensids[$index]['attributes']['nama'] }}"
                            {{ old('kategori', $subjek->penduduk . " - " . $this->subjek->nama_subjek) == $opensids[$index]['id'] . ' - ' . $opensids[$index]['attributes']['nama'] ? 'selected' : null}}>
                                {{ $opensids[$index]['attributes']['nama'] }}
                            </option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
        @error('nama_subjek')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @enderror
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
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_subjek">Nama Subjek Pajak<span class="{{ $showInput == null ? 'required' : '' }}">*</span></label>
        <div class="col-md-6 col-sm-6 ">
            <input type="text" wire:model="nama_subjek" id="nama_subjek" name="nama_subjek" class="form-control" {{ $showInput == true ? 'required' : '' }} value="{{ old('nama_subjek') ?? $subjek->nama_subjek }}">
        </div>
        @error('nama_subjek')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
