@foreach ($aplikasi as $data)
    <div class="item form-group d-flex align-items-center mb-2 {{ ($data->jenis == 'text' && $data->key != 'opensid_token' ? 'd-inline' : 'd-none') }}">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="value">{{ ucwords(str_replace('_', ' ', $data->key )) }}</label>
        <div class="col-md-4 col-sm-4">
            <input type="{{ $data->script == 'password' ? 'password' : 'text' }}" id="{{ $data->key }}" name="{{ $data->key }}" class="form-control @error('message') is-invalid @enderror" value="{{ old('value') ?? $data->value }}" {{ ($data->script == 'disabled' ? 'disabled' : '')}}>
        </div>
        <small class="col-md-5 col-sm-5 ms-2">{{ $data->keterangan }}.</small>
    </div>
@endforeach

<div class="item form-group d-flex align-items-center mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="akun_pengguna">Akun Pengguna</label>
    <div class="col-md-4 col-sm-4">
        <select class="form-select" id="akun_pengguna" name="akun_pengguna" class="form-control @error('akun_pengguna') is-invalid @enderror" autocomplete="off">
            <option value="" disabled>-- Pilih --</option>
            @foreach ($options as $item)
                <option value="{{ $item['value'] }}" {{ old('akun_pengguna', $akun_pengguna->value) == $item['value'] ? 'selected' : null}}>
                    {{ $item['label'] }}
                </option>
            @endforeach
        </select>
    </div>
    <small class="col-md-5 col-sm-5 ms-2">{{ $akun_pengguna->keterangan }}.</small>
</div>

<hr>

<div class="item form-group">
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary" type="reset">{{ $reset }}</button>
        <button type="submit" class="btn btn-success ms-2">{{ $submit }}</button>
    </div>
</div>

<div class="item form-group text-center">
    <livewire:pengaturan.sinkronisasi-opensid :aplikasi="$aplikasi">
</div>

