<x-app-layout title="{{ ucwords(str_replace('-', ' ', $table )) }}">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Master Data" active="{{ ucwords(str_replace('-', ' ', $table )) }}"></x-breadcrumbs>
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

                        <strong class="card-title">Ubah {{ ucwords(str_replace('-', ' ', $table )) }}</strong>
                    </div>

                    <div class="card-body">
                        <form action="{{ route($table.'.update', encrypt($data->id)) }}" method="post">
                            @csrf
                            @method('put')
                            @include('pages.master-data.periode._form-control')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!--  Datatables -->
    @include('layouts.includes._scripts-datatable')

    <!-- Hapus Beberapa Data -->
    @include('layouts.includes._scripts-bulk', ['table' => $table])
@endpush

</x-app-layout>
