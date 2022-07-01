<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Nama <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="name" name="name" required="required" class="form-control" value="{{ old('name') ?? $pengguna->name }}">
    </div>
    @error('name')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Nama Pengguna <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="username" name="username" required="required" class="form-control" value="{{ old('username') ?? $pengguna->username }}">
    </div>
    @error('username')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="email" name="email" required="required" class="form-control" value="{{ old('email') ?? $pengguna->email }}">
    </div>
    @error('email')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Kata Sandi </label>
    <div class="col-md-6 col-sm-6 ">
        <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}">
    </div>
    @error('password')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="item form-group align-items-center">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="photo">Foto Pengguna</label>
    <div class="col-md-6 col-sm-6 ">
        <input type="hidden" name="oldPhoto" value="{{ $pengguna->photo }}">
        @if($pengguna->photo)
            <div class="row align-items-center justify-content-center">
                <img src="{{ asset('storage/pengguna/' . $pengguna->photo) }}" class="photo-preview img-fluid mb-3 col-sm-6">
            </div>
        @else
            <div class="row align-items-center justify-content-center">
                <img class="photo-preview img-fluid mb-3 col-sm-6">
            </div>
        @endif

        <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror"
        autocomplete="off" style="height: 37px" onchange="previewPhoto()"/>
    </div>

    @error('photo')
    <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<hr>

<div class="item form-group {{ ($submit == 'Tambah' ? 'offset-md-2' : '') }}">
    <div class="col-md-6 col-sm-6">
        <button class="btn btn-primary" type="reset">{{ $reset }}</button>
        <button type="submit" class="btn btn-success">{{ $submit }}</button>
    </div>
</div>

@push('scripts')
<script>
    function previewPhoto(){
        const photo = document.querySelector('#photo');
        const photoPreview = document.querySelector('.photo-preview');

        photoPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(photo.files[0]);

        oFReader.onload = function(oFREvent){
            photoPreview.src = oFREvent.target.result;
        }
    }
</script>
@endpush
