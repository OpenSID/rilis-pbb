<x-app-layout title="{{ ucwords(str_replace('-', ' ', $title )) }}">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Master Data" active="{{ ucwords(str_replace('-', ' ', $title )) }}"></x-breadcrumbs>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="col-md-2">
                                <strong class="card-title">Data {{ ucwords(str_replace('-', ' ', $title )) }}</strong>
                            </div>

                            <div class="col-md-2 me-2">
                                <select id="filter_periode" name="filter_periode" class="form-select filter">
                                    <option value="" readonly>-- Pilih Tahun --</option>
                                    @foreach ($periodes as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <!-- Tombol Tambah Data -->
                            <a href="{{ route($table.'.create') }}" class="btn btn-success"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Data {{ ucwords($title) }}">
                                <i class="fa fa-plus-circle me-2"></i>Tambah
                            </a>

                            <!-- Tombol Hapus Data Yang Dipilih -->
                            <button type="button" class="btn btn-sm btn-danger btn-hapus-data-dipilih" id="deleteAllBtn" data-toggle="modal" data-target="#hapusDataDipilih-{{ $table }}" disabled
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Beberapa Data {{ ucwords($title) }}">
                                Hapus data yang dipilih
                             </button>

                            <!-- Modal Hapus Data Yang Dipilih -->
                            @include('layouts.modals.delete-selected', ['table' => $table])
                        </div>

                        <div class="table-responsive mt-3">
                            <livewire:master-data.rayon.table-rayon :rayons="$rayons" :table="$table" :title="$title">
                        </div>
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

    <script>
        $(".filter").on('change', function(){
            let periode = $('#filter_periode').val()
            console.log(periode)
            livewire.emit('setPilihTahunRayon', periode);
        })
    </script>
@endpush

</x-app-layout>
