<div class="mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="text-start alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Informasi : </strong> Pengaturan ini digunakan untuk sinkronisasi dengan OpenSID. <br />
                @foreach ($langkah_sinkronisasi as $langkah)
                    <small>{{ $langkah['no'] }} {{ $langkah['keterangan'] }} <strong>{{ $langkah['contoh'] }}</strong>. </small><br>
                @endforeach
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

    <div class="form-floating mb-3">
        <textarea wire:model="opensid_token" class="form-control {{ ($opensid_token ? 'd-inline' : 'd-none') }} text-primary" id="opensid_token" rows=5 disabled>{{ $opensid_token }}</textarea>
    </div>

    <button wire:click="Sinkronisasi()" type="button" class="btn btn-info-detail"><i class="fa fa-random"></i> Cek Sinkronisasi OpenSID</button>
</div>
