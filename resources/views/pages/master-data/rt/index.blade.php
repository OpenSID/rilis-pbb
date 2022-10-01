<x-app-layout title="{{ strtoupper($table) }}">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Master Data" active="{{ strtoupper($table) }}"></x-breadcrumbs>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Data {{ strtoupper($table) }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <!-- Tombol Tambah Data -->
                            <a href="{{ route($table.'.create') }}" class="btn btn-success"><i class="fa fa-plus-circle me-2"></i>Tambah</a>

                            <!-- Tombol Hapus Data Yang Dipilih -->
                            <button type="button" class="btn btn-sm btn-danger btn-hapus-data-dipilih" id="deleteAllBtn" data-toggle="modal" data-target="#hapusDataDipilih-{{ $table }}" disabled>
                                Hapus data yang dipilih
                             </button>

                            <!-- Modal Hapus Data Yang Dipilih -->
                            @include('layouts.modals.delete-selected', ['table' => $table])
                        </div>

                        <div class="table-responsive mt-3">
                            <table id="datatable" class="table table-striped table-bordered datatable">
                                <!-- Judul tabel -->
                                <thead>
                                    <tr role="row" class="odd">
                                        <th class="text-center"><input type="checkbox" id="check-all"></th>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama RT</th>
                                        <th class="text-center">Nama {{ucwords(str_replace('-', ' ', $aplikasi['sebutan_rayon'] )) }}</th>
                                        <th class="text-center">Total Pagu</th>
                                        <th class="text-center">Total Bayar</th>
                                        <th class="text-center">Kekurangan</th>
                                        <th class="text-center">Terpenuhi</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <!-- Isi data dalam tabel -->
                                <tbody>
                                    @foreach($rts as $index => $item)
                                        <tr id="sid{{ $item->id }}" class="{{ $item->rayon->nama_rayon ?? 'bg-warning'}}">
                                            <td class="text-center"><input type="checkbox" name="ids" class="checkBoxClass" value="{{ $item->id }}"></td>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $item->nama_rt }}</td>
                                            <td>{{ $item->rayon->nama_rayon ?? ''}}</td>
                                            <td class="text-end">
                                                {{ $item->total_pagu == 0 ? '-' : 'Rp. '.number_format($item->total_pagu, 0, ".", ".") }}
                                            </td>
                                            <td class="text-end text-success">
                                                {{ $item->total_bayar == 0 ? '-' : 'Rp. '.number_format($item->total_bayar, 0, ".", ".") }}
                                            </td>
                                            <td class="text-end text-danger">
                                                {{ ($item->total_pagu - $item->total_bayar) == 0 ? '-' : 'Rp. '.number_format(($item->total_pagu - $item->total_bayar), 0, ".", ".") }}
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                                        style="width: {{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}%;"
                                                        aria-valuenow="{{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}%
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <!-- Tombol Data Detail -->
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detil-{{ $table .'-'. $item->id }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Data Detil {{ ucwords(str_replace('-', ' ', $table )) }}">
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                </button>

                                                <!-- Modal Tabel Data Detail -->
                                                @include('pages.master-data.rt._modal-info', ['table' => $table , 'data' => $item])

                                                <!-- Tombol Ubah Data -->
                                                <a href="{{ route($table.'.edit', encrypt($item->id)) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <!-- Tombol Hapus Data -->
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#{{ $table }}-{{ $item->id }}">
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
