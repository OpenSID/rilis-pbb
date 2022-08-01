<div>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="staticBackdropLabel">Data Detil Objek Pajak</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="item form-group d-flex mb-2">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="kategori">Objek Pajak</label>
                    <div class="col-md-6 col-sm-6 me-2">
                        <select class="form-select" wire:model="kategori" id="kategori" name="kategori" class="form-control @error('kategori') is-invalid @enderror" autocomplete="off">
                            <option value="" readonly>-- Pilih Objek Pajak --</option>
                            @foreach ($options as $item)
                                <option value="{{ $item['value'] }}">
                                    {{ $item['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('kategori')
                    <div class="text-danger mt-1 d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="item form-group d-flex mb-2">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="luas_objek_pajak">Luas (m<sup>2</sup>)</label>
                    <div class="col-md-6 col-sm-6 me-2">
                        <input type="number" wire:model="luas_objek_pajak" id="luas_objek_pajak" name="luas_objek_pajak" required="required" oninput="maxLengthCheck(this)" maxlength="4" max="9999" class="form-control" value="{{ old('luas_objek_pajak') ?? '' }}">
                    </div>
                    @error('luas_objek_pajak')
                    <div class="text-danger mt-1 d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="item form-group d-flex mb-2">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="klas">Klas</label>
                    <div class="col-md-6 col-sm-6 me-2">
                        <input type="text" wire:model="klas" id="klas" name="klas" required="required" maxlength="3" class="form-control" value="{{ old('klas') ?? ''}}">
                    </div>
                    @error('klas')
                    <div class="text-danger mt-1 d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="item form-group d-flex mb-2">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="njop">NJOP PER m<sup>2</sup> (Rp.)</label>
                    <div class="col-md-6 col-sm-6 me-2">
                        <input type="number" wire:model="njop" id="njop" name="njop" required="required" oninput="maxLengthCheck(this)" maxlength="7" max="9999999" class="form-control" value="{{ old('njop') ?? '' }}">
                    </div>
                    @error('njop')
                    <div class="text-danger mt-1 d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="item form-group d-flex mb-2">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="periode_id">Periode</label>
                    <div class="col-md-6 col-sm-6 me-2">
                        <select class="form-select" wire:model="periode_id" id="periode_id" name="periode_id" class="form-control @error('periode_id') is-invalid @enderror" autocomplete="off">
                            <option value="" readonly>-- Pilih Periode --</option>
                            @foreach ($periodes as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            @if (session()->has('message-success'))
                <div class="text-center alert alert-success">
                    {{ session('message-success') }}
                </div>
            @elseif(session()->has('message-failed'))
                <div class="text-center alert alert-danger">
                    {{ session('message-failed') }}
                </div>
            @endif

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                <button type="button" class="btn btn-success" wire:click="Tambah">Tambah</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @include('layouts.includes._scripts-validation')
@endpush
