<x-app-layout title="Tambah Subjek Pajak">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Master Data" active="Tambah Subjek Pajak"></x-breadcrumbs>
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route($table.'.index') }}" class="btn btn-outline-secondary btn-circle me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali ke Tabel {{ ucwords(str_replace('-', ' ', $table )) }}">
                                <i class="fa fa-arrow-left"></i>
                            </a>

                            <strong class="card-title">Tambah Subjek Pajak</strong>
                        </div>

                        <div class="card-body">
                            <form action="{{ route($table.'.store') }}" method="post">
                                @csrf
                                <livewire:options.pilihan-subjek :options="$options" :subjek="$subjek" :opensids="$opensids" :totalpages="$totalpages">
                                @include('pages.master-data.subjek-pajak._form-control')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

</x-app-layout>
