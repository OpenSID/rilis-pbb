@foreach ($aplikasi as $data)
    <div class="item form-group align-items-center {{ ($data->jenis == 'image' ? 'd-inline' : 'd-none') }}">
        <label class="col-form-label col-md-12 col-sm-3 label-align text-center fw-bold" for="photo">{{ ucwords(str_replace('_', ' ', $data->key )) }}</label>
        <div class="col-md-12 col-sm-6 ">
            @if($data->value && $data->jenis == 'image')
                <div class="row align-items-center justify-content-center">
                    <img src="{{ asset('storage/pengaturan-aplikasi/' . $data->value) }}" class="{{ str_replace('_', '-', $data->key ) }}-preview img-fluid mb-3 col-md-12 col-sm-6">
                </div>
            @elseif($data->jenis == 'image')
                <div class="row align-items-center justify-content-center">
                    <img src="{{ asset('/build/images/opendesa/pengaturan-aplikasi/'.str_replace('_', '-', $data->key ).'.png') }}" class="{{ str_replace('_', '-', $data->key ) }}-preview img-fluid mb-3 col-md-12 col-sm-6">
                </div>
            @endif

            <small class="text-center text-danger d-block mb-2">({{ $data->keterangan }})</small>

            <div class="text-center">
                <button class="btn btn-info-detail btn-select-file" id="files" >Ubah Gambar</button>
                <input accept="image/*" type="file" name="{{ $data->key }}" id="{{ $data->key }}" class="form-control fade @error('{{ $data->key }}') is-invalid @enderror"
                autocomplete="off"/>
            </div>
        </div>

        @error('{{ $data->key }}')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @enderror

        <hr>
    </div>
@endforeach

<div class="item form-group">
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary" type="reset">{{ $reset }}</button>
        <button type="submit" class="btn btn-success">{{ $submit }}</button>
    </div>
</div>

@push('scripts')
<script nonce="{{ csp_nonce() }}">
document.addEventListener("DOMContentLoaded", () => {
    @foreach ($aplikasi as $data)
    $('input[name={{$data->key}}]').change(function(){
        {{ $data->script }}
    })
    @endforeach
})
    function previewLatarLogin(){
        const photo = document.querySelector('#latar_login');
        const photoPreview = document.querySelector('.latar-login-preview');

        photoPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(photo.files[0]);

        oFReader.onload = function(oFREvent){
            photoPreview.src = oFREvent.target.result;
        }
    }

    function previewLogoAplikasi(){
        const photo = document.querySelector('#logo_aplikasi');
        const photoPreview = document.querySelector('.logo-aplikasi-preview');

        photoPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(photo.files[0]);

        oFReader.onload = function(oFREvent){
            photoPreview.src = oFREvent.target.result;
        }
    }

    function previewLogoSurat(){
        const photo = document.querySelector('#logo_surat');
        const photoPreview = document.querySelector('.logo-surat-preview');

        photoPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(photo.files[0]);

        oFReader.onload = function(oFREvent){
            photoPreview.src = oFREvent.target.result;
        }
    }

    function previewLogoFavicon(){
        const photo = document.querySelector('#favicon');
        const photoPreview = document.querySelector('.favicon-preview');

        photoPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(photo.files[0]);

        oFReader.onload = function(oFREvent){
            photoPreview.src = oFREvent.target.result;
        }
    }
</script>
@endpush
