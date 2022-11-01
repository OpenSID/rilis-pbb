<div class="mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="text-start alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Informasi : </strong> Pengaturan ini digunakan untuk sinkronisasi dengan OpenSID. <br />
                <small>Sebelum klik tombol <strong>Cek Sinkronisasi OpenSID</strong>, pastikan <strong>Opensid Url</strong> dan <strong>Opensid Email</strong> terisi. Silakan ketikan <strong>Opensid Password</strong>, kemudian tekan tombol <strong>Simpan</strong> terlebih dahulu. !!!</small>
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

    <button wire:click="Sinkronisasi()" type="button" class="btn btn-info-detail"><i class="fa fa-random"></i> Cek Sinkronisasi OpenSID</button>
</div>
