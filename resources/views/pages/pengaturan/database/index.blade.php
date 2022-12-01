<x-app-layout title="Database">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Pengaturan" active="Database"></x-breadcrumbs>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Migrasi Database ke {{ pbb_version() }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{route('database.store')}}" method="post">
                            @csrf
                            <span>Proses ini untuk mengubah database Aplikasi PBB ke struktur database {{ pbb_version() }}.</span>

                            <p class="text-start alert alert-warning alert-dismissible fade show my-2">
                                <small>
                                    <strong><i class="fa fa-info-circle text-red"></i> Sebelum melakukan migrasi ini, pastikan database Anda telah dicadangkan (backup).</strong>
                                </small>
                            </p>

                            <p>Apabila sesudah melakukan konversi ini, masih ditemukan masalah, laporkan di :</p>

                            <div class="mx-4">
                                <ul>
                                    <li> <a href="https://github.com/OpenSID/wiki-pbb/issues" class="text-primary">https://github.com/OpenSID/wiki-pbb/issues</a></li>
                                    <li> <a href="https://www.facebook.com/groups/OpenSID/" class="text-primary">https://www.facebook.com/groups/OpenSID/</a></li>
                                </ul>
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
                            <button type="submit" class="btn btn-primary">Migrasi Database ke Aplikasi PBB {{ pbb_version() }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

</x-app-layout>
