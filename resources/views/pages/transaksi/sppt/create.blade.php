<x-app-layout title="Tambah {{ strtoupper($table) }}">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Transaksi" active="Tambah {{ strtoupper($table) }}"></x-breadcrumbs>
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route($table.'.index') }}" class="btn btn-outline-secondary btn-circle me-2"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali ke Tabel {{ strtoupper($table) }}">
                                <i class="fa fa-arrow-left"></i>
                            </a>

                            <strong class="card-title">Tambah {{ strtoupper($table) }}</strong>
                        </div>

                        <div class="card-body">
                            <form action="{{ route($table.'.store') }}" method="post">
                                @csrf
                                @livewire('options.pilihan-objek')
                                @include('pages.transaksi.sppt._form-control')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

</x-app-layout>
