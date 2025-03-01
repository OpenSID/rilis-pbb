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
                                <button type="button" class="btn btn-sm btn-danger btn-hapus-data-dipilih" id="deleteAllBtn" data-bs-toggle="modal" data-bs-target="#hapusDataDipilih-{{ $table }}" disabled
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
                                            <th class="text-center"><input type="checkbox" id="check-all"></th>
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
        <!-- Modal Tabel Data Detail -->
        @include('pages.master-data.objek-pajak._modal-info', ['table' => $table , 'data' => (object) ['id' => 1, 'objek_details' => []] ])
    @endsection

    @push('scripts')
        <!--  Datatables -->
        <!--  Kolom Datatable -->
        <script nonce="{{ csp_nonce() }}">
            var dataColumn =
                [
                    {data: 'id', name:'ids', defaultContent: '', orderable: false, sortable:false, searchable: false, targets: 0, className:'dt-center',
                        render:function(data){
                            return '<input type="checkbox" name="ids" class="checkBoxClass" value="' + data + '">';
                        }
                    },
                    {data: 'DT_RowIndex', className:'dt-center', orderable: false, sortable: false, searchable: false}, // row index
                    {data: 'letak_objek', name: 'letak_objek'},
                    {data: 'kode_blok', name: 'kode_blok', width: '80px', className:'dt-center'},
                    {data: 'alamat_objek', name: 'alamat_objek'},
                    {data: 'rt.nama_rt', name: 'rt.nama_rt', className:'dt-center',
                        render: function(data, row) {
                            return data ?? '';
                        },
                        searchable: false
                    },
                    {data: 'action', name: 'action', width: '113px', orderable: false, searchable: false},
                ];

            let deleteModal = document.getElementById('objek-pajak-1')
            deleteModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                let button = event.relatedTarget
                let idModal = '{{ $table }}-1'
                let urlAction = button.getAttribute('data-bs-urlaction')
                $('#'+idModal).find('form').attr('action', urlAction)
            })

            let detailModal = document.getElementById('detil-objek-pajak-1')
            detailModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                let button = event.relatedTarget
                let idModal = 'detil-{{ $table }}-1'
                let detail = JSON.parse(button.getAttribute('data-bs-detail'))
                let tr = []
                if (detail) {
                    detail.forEach((item, index) => {
                        tr.push(`
                        <tr class="${item?.periode?.tahun ?? 'bg-warning'}">
                        <td class="text-center">${index + 1}</td>
                        <td class="text-start">${item.kategori == 1 ? 'Bumi' : 'Bangunan'}</td>
                        <td class="text-end">${item.luas_objek_pajak_format}</td>
                        <td class="text-center">${item.klas}</td>
                        <td class="text-end">${item.njop_format}</td>
                        <td class="text-end">${item.total_njop_format}</td>
                        <td class="text-center">${item?.periode?.tahun}</td>
                        </tr>
                        `)
                    });
                }
                $('#table-detailobjek-pajak-1 tbody').html(tr.join(' '));
            })

        </script>
        @include('layouts.includes._scripts-datatable-serverside')

        <!-- Hapus Beberapa Data -->
        @include('layouts.includes._scripts-bulk-serverside', ['table' => $table])
    @endpush

</x-app-layout>
