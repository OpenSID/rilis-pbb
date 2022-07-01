<x-app-layout title="{{ ucwords(str_replace('-', ' ', $title )) }}">

@section('content')
<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12 vh-100">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">{{ ucwords(str_replace('-', ' ', $title )) }}</strong>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        <span>Data Gagal Dimuat, Harap Periksa Dibawah Ini</span><br>
                        <span>Fitur ini khusus untuk pelanggan Layanan OpenDesa</span><br>
                        <span>- Token pelanggan tidak terontentikasi. Periksa di Pengaturan Pelanggan</span><br>
                        <span>- Jika masih mengalami masalah harap menghubungi pelaksana masing-masing.</span><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

</x-app-layout>
