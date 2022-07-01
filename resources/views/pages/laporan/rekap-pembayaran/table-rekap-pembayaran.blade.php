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
                            <div class="">
                                <!-- Tombol Pilih Laporan -->
                                <button type="button" class="btn btn-sm btn-info-detail" data-bs-toggle="modal" data-bs-target="#downoload-{{ $table }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Laporan {{ ucwords(str_replace('-', ' ', $table )) }}">
                                    <i class="fa fa-file me-2"></i>Laporan Rekap
                                </button>

                                <!-- Modal Tabel Data Detail -->
                                @include('pages.laporan.rekap-pembayaran._modal-download-pdf', ['table' => $table])
                            </div>
                            <div class="table-responsive mt-3">
                                <table id="datatable" class="table table-striped table-bordered datatable">
                                    <!-- Judul tabel -->
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nomor SPPT</th>
                                            <th class="text-center">Nama Wajib Pajak</th>
                                            <th class="text-center">Nama Rayon</th>
                                            <th class="text-center">RT</th>
                                            <th class="text-center">Pagu Pajak</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>

                                    <!-- Isi data dalam tabel -->
                                    <tbody>
                                        @foreach($rekaps as $index => $item)
                                            <tr class="{{ $item->subjek_pajak->nama_subjek ?? 'bg-warning' }} {{ $item->objek_pajak->rt->nama_rt ?? 'bg-warning' }} {{ $item->objek_pajak->rt->rayon->nama_rayon ?? 'bg-warning' }}">
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $item->nop }}</td>
                                                <td>{{ $item->subjek_pajak->nama_subjek ?? '' }}</td>
                                                <td>{{ $item->objek_pajak->rt->rayon->nama_rayon ?? '' }}</td>
                                                <td>{{ $item->objek_pajak->rt->nama_rt ?? ''}}</td>
                                                <td class="text-end">Rp {{ $item->nilai_pagu_pajak == 0 ? '-' : number_format($item->nilai_pagu_pajak, 0, ".", ".") }}</td>
                                                <td class="text-center">
                                                    @if($item->status == 1)
                                                        <span class="badge badge-danger">Terhutang</span>
                                                    @else
                                                        <span class="badge badge-success">Lunas</span>
                                                    @endif
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
    @endpush

</x-app-layout>
