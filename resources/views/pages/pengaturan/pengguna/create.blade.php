<x-app-layout title="Tambah Pengguna">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Pengaturan" active="Tambah Pengguna"></x-breadcrumbs>
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary btn-circle me-2">
                                <i class="fa fa-arrow-left"></i>
                            </a>

                            <strong class="card-title">Tambah Pengguna</strong>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('pengguna.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @include('pages.pengaturan.pengguna._form-control')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

</x-app-layout>
