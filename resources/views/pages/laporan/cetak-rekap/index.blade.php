<x-app-layout title="{{ ucwords(str_replace('-', ' ', $table )) }}">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Laporan" active="{{ ucwords(str_replace('-', ' ', $table )) }}"></x-breadcrumbs>
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{ ucwords(str_replace('-', ' ', $table )) }}</strong>
                        </div>
                        <div class="card-body">
                            <livewire:laporan.cetak-rekap.form-cetak :btn_menus="$btn_menus" :table="$table">

                            <div class="table-responsive mt-3">
                                <livewire:laporan.cetak-rekap.table-cetak>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</x-app-layout>
