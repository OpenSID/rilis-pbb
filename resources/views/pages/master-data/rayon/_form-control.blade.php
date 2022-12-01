<div class="item form-group d-flex align-items-center mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_rayon">Nama {{ ucwords(str_replace('-', ' ', $title )) }} <span class="required">*</span></label>
    <div class="col-md-5 col-sm-5 ">
        <input type="text" id="nama_rayon" name="nama_rayon" required class="form-control" value="{{ old('nama_rayon') ?? $data->nama_rayon }}">
    </div>
    @error('nama_rayon')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="foto_rayon">Foto {{ ucwords(str_replace('-', ' ', $title )) }}</label>
    <div class="col-md-5 col-sm-5">
        <div>
            <button class="btn btn-info-detail" id="files" onclick="document.getElementById('foto_rayon').click(); return false;">Pilih foto {{ strtolower(str_replace('-', ' ', $title )) }} yang akan diunggah</button>
            <input style="visibility: hidden" accept="image/*" type="file" name="foto_rayon" id="foto_rayon" class="me-2 form-control @error('foto_rayon') is-invalid @enderror"
            autocomplete="off" style="height: 37px" onchange="previewPhoto()"/>
        </div>

        <input type="hidden" name="oldPhoto" value="{{ $data->foto_rayon }}">
        @if($data->foto_rayon)
            <div class="row align-items-center justify-content-center">
                <img src="{{ asset('storage/rayon/' . $data->foto_rayon) }}" class="photo-preview img-fluid mb-3 col-sm-6">
            </div>
        @else
            <div class="row align-items-center justify-content-center">
                <img class="photo-preview img-fluid mb-3 col-sm-6">
            </div>
        @endif
    </div>

    @error('foto_rayon')
    <div class="text-danger ms-1 d-block">{{ $message }}</div>
    @enderror
</div>

<hr>

<div class="item form-group">
    <div class="col-md-12 col-sm-12 text-end">
        <button class="btn btn-primary" type="reset"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $reset }} Data {{ ucwords(str_replace('-', ' ', $title )) }}">
            {{ $reset }}
        </button>
        <button type="submit" class="btn btn-success"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $submit }} Data {{ ucwords(str_replace('-', ' ', $title )) }}">
            {{ $submit }}
        </button>
    </div>
</div>

@push('scripts')
<script>
    function previewPhoto(){
        const photo = document.querySelector('#foto_rayon');
        const photoPreview = document.querySelector('.photo-preview');

        photoPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(photo.files[0]);

        oFReader.onload = function(oFREvent){
            photoPreview.src = oFREvent.target.result;
        }
    }

    $(document).ready(function () {
        var elements = document.getElementsByTagName("INPUT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function (e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    switch (e.srcElement.id) {
                        case "nama_rayon":
                            e.target.setCustomValidity("silakan isi nama {{ strtolower(str_replace('-', ' ', $title )) }}  !!!");
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
