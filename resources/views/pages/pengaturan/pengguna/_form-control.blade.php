<div class="row item form-group mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Nama <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="name" name="name" class="form-control" required
            value="{{ old('name') ?? $pengguna->name }}">
    </div>
    @error('name')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="row item form-group mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Nama Pengguna <span
            class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="username" name="username" class="form-control" required
            value="{{ old('username') ?? $pengguna->username }}">
    </div>
    @error('username')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="row item form-group mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span
            class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="email" name="email" class="form-control" required
            value="{{ old('email') ?? $pengguna->email }}">
    </div>
    @error('email')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="row item form-group mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="telegram_id">Telegram ID</label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="telegram_id" name="telegram_id" class="form-control"
            value="{{ old('telegram_id') ?? $pengguna->telegram_id }}" placeholder="Contoh: 123456789">
        <small class="form-text text-muted">
            <i class="fas fa-info-circle mr-1"></i>
            Hubungi bot @userinfobot di Telegram dan ketik /start untuk mendapatkan Telegram ID
        </small>
    </div>
    @error('telegram_id')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<div class="row item form-group mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Kata Sandi </label>
    <div class="col-md-6 col-sm-6">
        <div class="input-group">
            <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}">
            <div class="input-group-append">
                <button type="button" class="btn btn-outline-light" id="togglePassword">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
        </div>
        @error('password')
            <div class="text-danger mt-1 d-block">{{ $message }}</div>
        @else
            <div class="text-primary mt-1 d-block">Minimal 8 karakter terdiri dari huruf besar, huruf kecil, angka dan
                simbol. !!!</div>
        @enderror
    </div>

</div>


<div class="row item form-group mb-2 align-items-center">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="photo">Foto Pengguna</label>
    <div class="col-md-6 col-sm-6 ">
        @if ($pengguna->photo)
            <div class="row align-items-center">
                <img src="{{ asset('storage/pengguna/' . $pengguna->photo) }}"
                    class="photo-preview img-fluid mb-3 col-sm-6">
            </div>
        @else
            <div class="row align-items-center">
                <img class="photo-preview img-fluid mb-3 col-sm-6">
            </div>
        @endif

        <div>
            <button class="btn btn-info-detail btn-select-file" id="files">Pilih foto pengguna yang akan
                diunggah</button>
            <input accept="image/*" type="file" name="photo" id="photo"
                class="form-control fade @error('photo') is-invalid @enderror" autocomplete="off" />
        </div>
    </div>

    @error('photo')
        <div class="text-danger mt-1 d-block">{{ $message }}</div>
    @enderror
</div>

<hr>

<div class="row item form-group mb-2 {{ $submit == 'Tambah' ? 'offset-md-2' : '' }}">
    <div class="col-md-6 col-sm-6">
        <button class="btn btn-primary" type="reset">{{ $reset }}</button>
        <button type="submit" class="btn btn-success">{{ $submit }}</button>
    </div>
</div>
<style nonce="{{ csp_nonce() }}">
    .btn-outline-light {
        color: #adb5bd !important;
        /* Warna abu-abu muda */
        border-color: #adb5bd !important;
    }

    .btn-outline-light:hover {
        background-color: #adb5bd;
        color: white !important;
    }
</style>

@push('scripts')
    <script nonce="{{ csp_nonce() }}">
        function previewPhoto() {
            const photo = document.querySelector('#photo');
            const photoPreview = document.querySelector('.photo-preview');

            photoPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(photo.files[0]);

            oFReader.onload = function(oFREvent) {
                photoPreview.src = oFREvent.target.result;
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            $('#photo').on('change', previewPhoto);

            var elements = document.getElementsByTagName("INPUT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function(e) {
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        switch (e.srcElement.id) {
                            case "name":
                                e.target.setCustomValidity("silakan isi nama lengkap !!!");
                                break;
                            case "username":
                                e.target.setCustomValidity(
                                    "silakan isi nama pengguna, hanya boleh berisi huruf, angka, dan strip.!!!"
                                    );
                                break;
                            case "email":
                                e.target.setCustomValidity("silakan isi email pengguna !!!");
                                break;
                            case "password":
                                e.target.setCustomValidity(
                                    "silakan isi kata sandi, harus minimal 8 karakter terdiri dari huruf besar, huruf kecil, angka dan simbol. !!!"
                                    );
                                break;
                        }
                    }
                };
                elements[i].oninput = function(e) {
                    e.target.setCustomValidity("");
                };
            }
            const togglePassword = document.querySelector("#togglePassword");
            const passwordInput = document.querySelector("#password");

            togglePassword.addEventListener("click", function() {
                // Toggle tipe input antara 'password' dan 'text'
                const type = passwordInput.type === "password" ? "text" : "password";
                passwordInput.type = type;

                // Ganti ikon antara mata terbuka dan tertutup
                this.innerHTML = type === "password" ? '<i class="fa fa-eye"></i>' :
                    '<i class="fa fa-eye-slash"></i>';
            });
        })
    </script>
@endpush
