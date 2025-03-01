<x-app-layout title="{{ strtoupper($table) }}">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Transaksi" active="{{ strtoupper($table) }}"></x-breadcrumbs>
@endsection

@section('content')
    <div class="animated fadeIn">
        @include('common.errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="col-md-2">
                                <strong class="card-title">Data {{ strtoupper($table) }}</strong>
                            </div>

                            <div class="col-md-2 me-2">
                                <select id="filter_periode" name="filter_periode" data-column="6" class="form-select filter">
                                    <option value="" readonly>-- Pilih Tahun --</option>
                                    @foreach ($periodes as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 me-2">
                                <select id="filter_status" name="filter_status" data-column="5" class="form-select filter">
                                    <option value="" readonly>-- Pilih Status --</option>
                                    @foreach ($statusItems as $key => $item)
                                        <option value="{{ $key }}">
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 me-2">
                                <select id="filter_rt" name="filter_rt" data-column="8" class="form-select filter">
                                    <option value="" readonly>-- Pilih RT --</option>
                                    @foreach ($rtItems as $key => $item)
                                        <option value="{{ $key }}">
                                            {{ $item }}
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
                                <a href="#" id="sppt-ekspor" data-href="{{ route($table.'.export-excel') }}" class="btn btn-secondary"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Ekspor data {{ strtoupper($table) }} ke excel">
                                    <i class="fa fa-download me-2"></i>Ekspor
                                </a>

                                <!-- Tombol Import Data Excel -->
                                <button type="button" class="btn btn-primary" id="importExcel" data-bs-toggle="modal" data-bs-target="#importExcel-{{ $table }}"
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
                                      <li><button class="dropdown-item btn-salin-data-dipilih" id="salinSelectBtn" data-bs-toggle="modal" data-bs-target="#salinDataDipilih-{{ $table }}" disabled>Salin data terpilih</button></li>
                                      <li><button class="dropdown-item" id="salinSemuaPeriode" data-bs-toggle="modal" data-bs-target="#salinSemuaPeriode-{{ $table }}" >Salin semua data</button></li>
                                    </ul>
                                </div>

                                <!-- Tombol Bayar Data Yang Dipilih -->
                                <button type="button" class="btn btn-warning btn-bayar-data-dipilih" id="bayarSemuaBtn" data-bs-toggle="modal" data-bs-target="#bayar-sppt-massal"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Bayar SPPT Massal">
                                    Bayar data yang dipilih
                                </button>

                                <!-- Modal Bayar Data Yang Dipilih -->
                                @include('layouts.modals.bayar', ['table' => 'pembayaran'])

                                <!-- Modal Salin Data Yang Dipilih -->
                                @include('layouts.modals.salin-sppt-terpilih', ['table' => $table])

                                <!-- Modal Salin Semua Data SPPT berdasarkan Periode Tertentu -->
                                @include('layouts.modals.salin-sppt-periode', ['table' => $table, '$periodes' => $periodes])
                            </div>

                            <!-- Tombol Hapus Data Yang Dipilih -->
                            <button type="button" class="btn btn-sm btn-danger btn-hapus-data-dipilih" id="deleteAllBtn" data-bs-toggle="modal" data-bs-target="#hapusDataDipilih-{{ $table }}" disabled
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
                                        <th class="text-center">Subjek / Nama Wajib Pajak</th>
                                        <th class="text-center">Pagu Pajak</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Aksi</th>
                                        <th class="text-center">RT</th>
                                    </tr>
                                </thead>

                                <!-- Isi data dalam tabel -->
                                <tbody>

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
    <!-- Modal Salin SPPT -->
    @include('layouts.modals.salin-sppt', ['table' => $table , 'data' => (object) ['id' => 1]])
    <!-- Modal Batal Pembayaran -->
    @include('layouts.modals.batal-bayar', ['table' => 'pembayaran' , 'data' => (object) ['id' => 1]])
@endsection

@push('scripts')
    <!--  Datatables -->
    <!--  Kolom Datatable -->
    <script nonce="{{ csp_nonce() }}">
        var dataColumn =
            [
                {data: 'id', name:'ids', defaultContent: '', orderable: false, sortable: false, searchable: false, targets: 0, className:'dt-center',
                    render:function(data){
                        return '<input type="checkbox" name="ids" class="checkBoxClass" value="' + data + '">';
                    }
                },
                {data: 'DT_RowIndex', className:'dt-center', orderable: false, sortable: false, searchable: false}, // row index
                {data: 'nop', name: 'nop', className:'nop'},
                {data: 'subjek_pajak.nama_subjek', name: 'subjek_pajak.nama_subjek', className:'nama_subjek',
                    render: function(data, row) {
                        return data ?? '';
                    },
                },
                {data: 'nilai_pagu_pajak', name: 'nilai_pagu_pajak', className:'dt-right nilai_pagu_pajak',
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
                            return '<span class="badge badge-danger terhutang">Terhutang</span>';
                        }else{
                            return '<span class="badge badge-success lunas">Lunas</span>';
                        }
                    },
                },
                {data: 'periode_id', name: 'periode_id', className:'dt-center',
                    render: function(data) {
                        return data ?? '';
                    },
                },
                {data: 'action', name: 'action', className:'dt-center', width: '120px', orderable: false, searchable: false},
                {data: 'objek_pajak_id', name: 'objek_pajak_id', className:'dt-center', defaultContent: '-', width: '120px', orderable: false, searchable: true, visible: false},

            ];

            let deleteModal = document.getElementById('sppt-1')
            deleteModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                let button = event.relatedTarget
                let idModal = '{{ $table }}-1'
                let urlAction = button.getAttribute('data-bs-urlaction')
                $('#'+idModal).find('form').attr('action', urlAction)
            })

            let salinModal = document.getElementById('salin-sppt-1')
            salinModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                let button = event.relatedTarget
                let idModal = 'salin-sppt-1'
                let urlAction = button.getAttribute('data-bs-urlaction')
                let nop = button.getAttribute('data-bs-nop')
                let namaSubjek = button.getAttribute('data-bs-namasubjek')
                let nilaiPagu = button.getAttribute('data-bs-nilaipagu')

                $('#'+idModal).find('form').attr('action', urlAction)
                $('#'+idModal).find('span.data-nop').text(nop)
                $('#'+idModal).find('span.data-nama_subjek').text(namaSubjek)
                $('#'+idModal).find('input#nilai_pagu_pajak').val(nilaiPagu)
            })

            let batalBayarModal = document.getElementById('pembayaran-1')
            batalBayarModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                let button = event.relatedTarget
                let idModal = 'pembayaran-1'
                let urlAction = button.getAttribute('data-bs-urlaction')
                $('#'+idModal).find('form').attr('action', urlAction)
            })

            let bayarMassalModal = document.getElementById('bayar-sppt-massal')
            bayarMassalModal.addEventListener('show.bs.modal', function (event) {
                let checkbox_terpilih = $('#datatable tbody .checkBoxClass:checked')
                let allids = [], _tr, _totalBayar = 0, objTerpilih = []
                let contenttable = bayarMassalModal.querySelector('div.content-table')
                let datatableObj = $('#datatable').DataTable()
                $(bayarMassalModal).find('button:submit').hide()
                $.each(checkbox_terpilih, function(index,elm){
                    _tr = elm.closest('tr')
                    if (datatableObj.row(_tr).data().status == 1){
                        objTerpilih.push(datatableObj.row(_tr).data())
                        _totalBayar += parseInt(datatableObj.row(_tr).data().nilai_pagu_pajak)
                        allids.push(datatableObj.row(_tr).data().id)
                    }
                })

                if (!objTerpilih.length){
                    contenttable.innerHTML = 'Tidak ada data SPPT terhutang yang dipilih'
                } else {
                    let _tableBayar = [
                        `<table class="table table-striped table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>NOP</th>
                                    <th>Nama Wajib Pajak</th>
                                    <th>Pagu Pajak</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody>`
                    ]
                    objTerpilih.forEach( (element, index) => {
                        _tableBayar.push(`<tr>
                                <td class="text-center">${index+1}</td>
                                <td>${element.nop}</td>
                                <td>${element.subjek_pajak.nama_subjek}</td>
                                <td class="text-end">${$.fn.dataTable.render.number('.', ',', 0, 'Rp').display( element.nilai_pagu_pajak )},-</td>
                                <td>${element.periode.tahun}</td>
                            </tr>`)
                    });
                    _tableBayar.push(`</tbody>`)
                    _tableBayar.push(`<tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total Pagu</th>
                                <th class="text-end">${$.fn.dataTable.render.number('.', ',', 0, 'Rp').display( _totalBayar )},-</th>
                                <th></th>
                            </tr>
                        </tfoot>`)
                    _tableBayar.push(`</table>`)
                    contenttable.innerHTML = `
                        ${_tableBayar.join('')}
                        <input type="hidden" name="ids" value="${allids}" />
                        <div class="item form-group d-flex mb-2">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="tanggal_bayar">Tanggal Bayar</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="date" required name="tanggal_bayar">
                            </div>
                        </div>
                        <div class="item form-group d-flex mb-2">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_pembayar_pajak">Nama Pembayar Pajak</label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" required name="nama_pembayar_pajak" class="form-control" value="">
                            </div>
                        </div>
                        <div class="item form-group d-flex mb-2">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="alamat_pembayar_pajak">Alamat Pembayar Pajak</label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" required name="alamat_pembayar_pajak" class="form-control" value="">
                            </div>
                        </div>
                    `
                    $(bayarMassalModal).find('button:submit').show()
                }

                // // Button that triggered the modal
                // let button = event.relatedTarget
                // let idModal = 'pembayaran-1'
                // let urlAction = button.getAttribute('data-bs-urlaction')
                // $('#'+idModal).find('form').attr('action', urlAction)
            })

            document.addEventListener("DOMContentLoaded", () => {
                $('input[name=nilai_pagu_pajak]').inputmask('numeric', {max: 999999999})
                $('#sppt-ekspor').on('click', function(){
                    let url = $(this).data('href')
                    let filter_periode = $('#filter_periode').val()
                    let filter_status = $('#filter_status').val()
                    let filter_rt = $('#filter_rt').val()
                    let params = []
                    if (filter_periode) params.push('periode_id='+filter_periode)
                    if (filter_status) params.push('status='+filter_status)
                    if (filter_rt) params.push('rt_id='+filter_rt)
                    if (params.length) url += '?'+params.join('&')
                    window.location.href = url
                })
            })
    </script>
    @include('layouts.includes._scripts-datatable-serverside')

    <!-- Hapus Beberapa Data -->
    @include('layouts.includes._scripts-bulk-serverside', ['table' => $table])

    <!-- Salin Beberapa Data -->
    @include('layouts.includes._scripts-salin-serverside', ['table' => $table])
@endpush

</x-app-layout>
