<x-app-layout title="{{ strtoupper($table) }}">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Transaksi" active="{{ strtoupper($table) }}"></x-breadcrumbs>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="col-md-2">
                                <strong class="card-title">Data {{ strtoupper($table) }}</strong>
                            </div>

                            <div class="col-md-2 me-2">
                                <select id="filter_periode" name="filter_periode" class="form-select filter">
                                    <option value="" readonly>-- Pilih Tahun --</option>
                                    @foreach ($periodes as $item)
                                        <option value="{{ $item->tahun }}">
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <!-- Tombol Tambah Data -->
                                <a href="{{ route($table.'.create') }}" class="btn btn-success"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Data {{ strtoupper($table) }}">
                                    <i class="fa fa-plus-circle me-2"></i>Tambah
                                </a>

                                <!-- Tombol Export Data Excel -->
                                <a href="{{ route($table.'.export-excel') }}" class="btn btn-secondary"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Ekspor data {{ strtoupper($table) }} ke excel">
                                    <i class="fa fa-download me-2"></i>Ekspor
                                </a>

                                <!-- Tombol Import Data Excel -->
                                <button type="button" class="btn btn-primary" id="importExcel" data-toggle="modal" data-target="#importExcel-{{ $table }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Impor data {{ strtoupper($table) }} dari excel">
                                    <i class="fa fa-upload me-2"></i>Impor
                                </button>

                                <!-- Modal Hapus Data Yang Dipilih -->
                                @include('layouts.modals.import-excel', ['table' => $table, 'catatan' => $catatan])

                                <!-- Tombol Salin Data SPPT -->
                                <div class="btn-group dropdown">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Salin data {{ strtoupper($table) }}">
                                        <i class="fa fa-clone me-2 text-white"></i><span class="text-white">Salin</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-popup">
                                      <li><button class="dropdown-item btn-salin-data-dipilih" id="salinSelectBtn" data-toggle="modal" data-target="#salinDataDipilih-{{ $table }}" disabled>Salin data terpilih</button></li>
                                      <li><button class="dropdown-item" id="salinSemuaPeriode" data-toggle="modal" data-target="#salinSemuaPeriode-{{ $table }}" >Salin semua data</button></li>
                                    </ul>
                                </div>

                                <!-- Modal Salin Data Yang Dipilih -->
                                @include('layouts.modals.salin-sppt-terpilih', ['table' => $table])

                                <!-- Modal Salin Semua Data SPPT berdasarkan Periode Tertentu -->
                                @include('layouts.modals.salin-sppt-periode', ['table' => $table, '$periodes' => $periodes])
                            </div>

                            <!-- Tombol Hapus Data Yang Dipilih -->
                            <button type="button" class="btn btn-sm btn-danger btn-hapus-data-dipilih" id="deleteAllBtn" data-toggle="modal" data-target="#hapusDataDipilih-{{ $table }}" disabled
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Beberapa Data {{ strtoupper($table) }}">
                                Hapus data yang dipilih
                             </button>

                            <!-- Modal Hapus Data Yang Dipilih -->
                            @include('layouts.modals.delete-selected', ['table' => $table])
                        </div>
                        <div class="table-responsive mt-3">
                            {{-- <livewire:transaksi.sppt.table-sppt :sppts="$sppts" :table="$table"> --}}
                            <table id="datatable" class="table table-striped table-bordered datatable">
                                <!-- Judul tabel -->
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" id="check-all"></th>
                                        <th class="text-center">No</th>
                                        <th class="text-center">NOP</th>
                                        <th class="text-center">Nama Wajib Pajak</th>
                                        <th class="text-center">Pagu Pajak</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <!-- Isi data dalam tabel -->
                                <tbody>
                                    @foreach($sppts as $index => $item)
                                        <!-- Modal Hapus Data -->
                                        @include('layouts.modals.delete', ['table' => $table , 'data' => $item])

                                        <!-- Modal Salin SPPT -->
                                        @include('layouts.modals.salin-sppt', ['table' => $table , 'data' => $item])

                                        <!-- Modal Batal Pembayaran -->
                                        @include('layouts.modals.batal-bayar', ['table' => 'pembayaran' , 'data' => $item])
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
    <!--  Kolom Datatable -->
    <script>
        var dataColumn =
            [
                {data: 'id', name:'ids', defaultContent: '', orderable: false, sortable: false, searchable: false, targets: 0, className:'dt-center',
                    render:function(data){
                        return '<input type="checkbox" name="ids" class="checkBoxClass" value="' + data + '">';
                    }
                },
                {data: 'DT_RowIndex', className:'dt-center', orderable: false, sortable: false, searchable: false}, // row index
                {data: 'nop', name: 'nop'},
                {data: 'subjek_pajak.nama_subjek', name: 'subjek_pajak.nama_subjek',
                    render: function(data, row) {
                        return data ?? '';
                    },
                },
                {data: 'nilai_pagu_pajak', name: 'nilai_pagu_pajak', className:'dt-right',
                    render: function(data) {
                        if(data == 0) {
                            return 'Rp -';
                        }else{
                            return $.fn.dataTable.render.number('.', ',', 0, 'Rp').display( data ) + ',-';
                        }
                    },
                },
                {data: 'status', name: 'status', width: '100px', className:'dt-center',
                    render: function(data) {
                        if(data == 1) {
                            return '<span class="badge badge-danger">Terhutang</span>';
                        }else{
                            return '<span class="badge badge-success">Lunas</span>';
                        }
                    },
                },
                {data: 'periode.tahun', name: 'periode.tahun', className:'dt-center',
                    render: function(data) {
                        return data ?? '';
                    },
                },
                {data: 'action', name: 'action', className:'dt-center', width: '120px', orderable: false, searchable: false},
            ];
    </script>
    @include('layouts.includes._scripts-datatable-serverside')

    <!-- Hapus Beberapa Data -->
    @include('layouts.includes._scripts-bulk-serverside', ['table' => $table])

    <!-- Salin Beberapa Data -->
    @include('layouts.includes._scripts-salin-serverside', ['table' => $table])
@endpush

</x-app-layout>
