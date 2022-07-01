<x-app-layout title="{{ ucwords(str_replace('-', ' ', $table )) }}">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Master Data" active="{{ ucwords(str_replace('-', ' ', $table )) }}"></x-breadcrumbs>
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Data {{ ucwords(str_replace('-', ' ', $table )) }}</strong>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <!-- Tombol Tambah Data -->
                                <a href="{{ route($table.'.create') }}" class="btn btn-success"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Data {{ ucwords(str_replace('-', ' ', $table )) }}">
                                    <i class="fa fa-plus-circle me-2"></i>Tambah
                                </a>

                                <!-- Tombol Hapus Data Yang Dipilih -->
                                <button type="button" class="btn btn-sm btn-danger btn-hapus-data-dipilih" id="deleteAllBtn" data-toggle="modal" data-target="#hapusDataDipilih-{{ $table }}" disabled
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Beberapa Data {{ ucwords(str_replace('-', ' ', $table )) }}">
                                    Hapus data yang dipilih
                                 </button>

                                <!-- Modal Hapus Data Yang Dipilih -->
                                @include('layouts.modals.delete-selected', ['table' => $table])
                            </div>
                            <div class="table-responsive mt-3">
                                <table id="datatable" class="table table-striped table-bordered datatable">
                                    <!-- Judul tabel -->
                                    <thead>
                                        <tr>
                                            <th class="text-end"><input type="checkbox" id="check-all"></th>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Letak Objek Pajak</th>
                                            <th class="text-center">Kode Blok</th>
                                            <th class="text-center">Alamat Objek Pajak</th>
                                            <th class="text-center">RT</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>

                                    <!-- Isi data dalam tabel -->
                                    <tbody>
                                        @foreach($objeks as $index => $item)
                                            <tr id="sid{{ $item->id }}" class="{{ $item->rt->nama_rt ?? 'bg-warning' }}">
                                                <td class="text-center"><input type="checkbox" name="ids" class="checkBoxClass" value="{{ $item->id }}"></td>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $item->letak_objek }}</td>
                                                <td class="text-center">{{ $item->kode_blok }}</td>
                                                <td>{{ $item->alamat_objek }}</td>
                                                <td class="text-center">{{ $item->rt->nama_rt ?? '' }}</td>

                                                <td class="text-center">
                                                    <!-- Tombol Data Detail -->
                                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detil-{{ $table .'-'. $item->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Data Detil {{ ucwords(str_replace('-', ' ', $table )) }}">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                    </button>

                                                    <!-- Modal Tabel Data Detail -->
                                                    @include('pages.master-data.objek-pajak._modal-info', ['table' => $table , 'data' => $item])

                                                    <!-- Tombol Ubah Data -->
                                                    <a href="{{ route($table.'.edit', encrypt($item->id)) }}" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Data {{ ucwords(str_replace('-', ' ', $table )) }}">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>

                                                    <!-- Tombol Hapus Data -->
                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#{{ $table .'-'. $item->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data {{ ucwords(str_replace('-', ' ', $table )) }}">
                                                       <i class="fa fa-trash"></i>
                                                    </button>

                                                    <!-- Modal Hapus Data -->
                                                    @include('layouts.modals.delete', ['table' => $table , 'data' => $item])
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    @endpush

</x-app-layout>
