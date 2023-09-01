<x-app-layout title="Subjek Pajak">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Master Data" active="Subjek Pajak"></x-breadcrumbs>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Data Subjek Pajak</strong>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <!-- Tombol Tambah Data -->
                            <a href="{{ route($table.'.create') }}" class="btn btn-success"><i class="fa fa-plus-circle me-2"></i>Tambah</a>

                            <!-- Tombol Hapus Data Yang Dipilih -->
                            <button type="button" class="btn btn-sm btn-danger btn-hapus-data-dipilih" id="deleteAllBtn" data-bs-toggle="modal" data-bs-target="#hapusDataDipilih-{{ $table }}" disabled>
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
                                        <th class="text-center"><input type="checkbox" id="check-all"></th>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Subjek Pajak</th>
                                        <th class="text-center">Alamat Subjek Pajak</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">NPWP</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <!-- Isi data dalam tabel -->
                                <tbody>
                                    @foreach($subjeks as $index => $item)

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- untuk modal delete -->
    @include('layouts.modals.delete', ['table' => $table , 'data' =>  (object) ['id' => 1] ])
@endsection

@push('scripts')
    <!--  Datatables -->
    <!--  Kolom Datatable -->
    <script nonce="{{ csp_nonce() }}" type="text/javascript">
    let dataColumn =
            [
                {data: 'id', name:'ids', defaultContent: '', orderable: false, sortable: false, searchable: false, targets: 0, className:'dt-center',
                    render:function(data){
                        return '<input type="checkbox" name="ids" class="checkBoxClass" value="' + data + '">';
                    }
                },
                {data: 'DT_RowIndex', className:'dt-center', orderable: false, sortable: false, searchable: false}, // row index
                {data: 'nama_subjek', name: 'nama_subjek'},
                {data: 'alamat_subjek', name: 'alamat_subjek'},
                {data: 'kategori', name: 'kategori', width: '100px',
                    render: function(data) {
                        if(data == 1) {
                            return 'Penduduk';
                        }else if(data == 2){
                            return 'Luar Penduduk';
                        }else{
                            return 'Badan';
                        }
                    },
                },
                {data: 'npwp', name: 'npwp'},
                {data: 'action', name: 'action', className: 'action',width: '73px', orderable: false, searchable: false},
            ];

        let deleteModal = document.getElementById('subjek-pajak-1')
        deleteModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            let button = event.relatedTarget
            let idModal = '{{ $table }}-1'
            let urlAction = button.getAttribute('data-bs-urlaction')
            $('#'+idModal).find('form').attr('action', urlAction)
        })
    </script>
    <!--  Menampilkan Datatable -->
    @include('layouts.includes._scripts-datatable-serverside')

    <!-- Hapus Beberapa Data -->
    @include('layouts.includes._scripts-bulk-serverside', ['table' => $table])
@endpush

</x-app-layout>
