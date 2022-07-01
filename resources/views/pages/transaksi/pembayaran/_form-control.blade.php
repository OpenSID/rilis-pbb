<livewire:options.pilihan-sppt>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="tanggal_bayar">Tanggal Bayar</label>
    <div class="col-md-6 col-sm-6">
        <input class="form-control" type="date" name="tanggal_bayar" id="tanggal_bayar"/>
    </div>
    @error('tanggal_bayar')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_pembayar_pajak">Nama Pembayar Pajak</label>
    <div class="col-md-6 col-sm-6">
        <input type="text" id="nama_pembayar_pajak" name="nama_pembayar_pajak" class="form-control" value="{{ old('nama_pembayar_pajak') ?? $pembayaran->nama_pembayar_pajak }}">
    </div>
    @error('nama_pembayar_pajak')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="alamat_pembayar_pajak">Alamat Pembayar Pajak</label>
    <div class="col-md-6 col-sm-6">
        <input type="text" id="alamat_pembayar_pajak" name="alamat_pembayar_pajak" class="form-control" value="{{ old('alamat_pembayar_pajak') ?? $pembayaran->alamat_pembayar_pajak }}">
    </div>
    @error('alamat_pembayar_pajak')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
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

