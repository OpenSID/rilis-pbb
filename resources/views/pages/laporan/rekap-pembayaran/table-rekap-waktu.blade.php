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
                            <div class="table-responsive mt-3">
                                <table id="datatable" class="table table-striped table-bordered datatable">
                                    <!-- Judul tabel -->
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tanggal Pelunasan</th>
                                            <th class="text-center">Jumlah Penerimaan</th>
                                            <th class="text-center">Status Setor</th>
                                            <th class="text-center">Tanggal Setor</th>
                                        </tr>
                                    </thead>

                                    <!-- Isi data dalam tabel -->
                                    <tbody>
                                        @foreach($rekaps as $index => $item)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-info-detail" data-bs-toggle="modal" data-bs-target="#detil-{{ $table .'-'. $item->tanggal_bayar }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Data Detil {{ ucwords(str_replace('-', ' ', $table )) }}">
                                                        {{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_bayar)->isoFormat('D MMMM Y'); }}
                                                    </button>

                                                    <!-- Modal Tabel Data Detail -->
                                                    @include('pages.laporan.rekap-pembayaran._modal-info', ['table' => $table , 'data' => $item])
                                                </td>
                                                <td class="text-end text-success">
                                                    Rp {{ $item->total_penerimaan == 0 ? '-' : number_format($item->total_penerimaan, 0, ".", ".") }}
                                                </td>
                                                <td class="text-center">
                                                    @if($item->status_setor == 1)
                                                        <span class="badge badge-danger">Terhutang</span>
                                                    @else
                                                        <span class="badge badge-success">Lunas</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($item->tanggal_setor)
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_setor)->isoFormat('D MMMM Y'); }}

                                                            <form action="{{ route($table.'.destroy', $item->tanggal_bayar) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-danger btn-block ms-2"><i class="fa fa-times"></i></button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-success-detail" data-bs-toggle="modal" data-bs-target="#setor-{{ $table .'-'. $item->tanggal_bayar }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Data Detil {{ ucwords(str_replace('-', ' ', $table )) }}">
                                                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Setor
                                                        </button>

                                                        <!-- Modal Tabel Setor -->
                                                        @include('pages.laporan.rekap-pembayaran._modal-setor', ['table' => $table , 'data' => $item])
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
