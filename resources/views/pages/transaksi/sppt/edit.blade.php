<x-app-layout title="Ubah {{ strtoupper($table) }}">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Transaksi" active="Ubah {{ strtoupper($table) }}"></x-breadcrumbs>
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route($table.'.index') }}" class="btn btn-outline-secondary btn-circle me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali ke Tabel {{ strtoupper($table) }}">
                                <i class="fa fa-arrow-left"></i>
                            </a>

                            <strong class="card-title">Ubah {{ strtoupper($table) }}</strong>
                        </div>

                        <div class="card-body">
                            <form action="{{ route($table.'.update', encrypt($sppt->id)) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                @livewire('options.pilihan-objek', [
                                    'selectedObjek' => $sppt->objek_pajak_id ?? "",
                                    'selectedRT' => $sppt->objek_pajak->rt_id ?? "",
                                    'selectedRayon' => $sppt->objek_pajak->rt->rayon_id ?? "",
                                    'nop' => substr($sppt->nop,18,24),
                                    'blok' => $sppt->objek_pajak->kode_blok,
                                    'alamat_objek' => $sppt->objek_pajak->alamat_objek,
                                    'objek_pajak_id' => $sppt->objek_pajak->id,
                                ])
                                @include('pages.transaksi.sppt._form-control')
                            </form>

                            <span style="float: right; margin-top: -38px; margin-right: 188px;">
                                <!-- Tombol Hapus Data -->
                                <button type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#{{ $table }}-{{ $sppt->id }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus {{ strtoupper($table) }}">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>

                                <!-- Modal Hapus Data -->
                                @include('layouts.modals.delete', ['table' => $table , 'data' => $sppt])
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

</x-app-layout>
