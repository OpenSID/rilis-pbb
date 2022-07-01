<x-app-layout title="Tambah {{ strtoupper($table) }}">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Transaksi" active="Tambah {{ strtoupper($table) }}"></x-breadcrumbs>
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

                            <strong class="card-title">Tambah {{ strtoupper($table) }}</strong>
                        </div>

                        <div class="card-body">
                            <form action="{{ route($table.'.store') }}" method="post">
                                @csrf
                                {{-- <div class="item form-group d-flex mb-2">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nop">NOP<span class="required"> *</span></label>
                                    <div class="col-md-3 col-sm-3">
                                        <input type="text" id="nop_wilayah" name="nop_wilayah" required="required" class="form-control nop-wilayah" style="letter-spacing: 0.15em" value="{{ $kode_provinsi.'.'.$kode_kabupaten.'.'.$kode_kecamatan.'.'.$kode_desa.'.' }}">
                                    </div>
                                    <div class="col-md-1 col-sm-1">
                                        <input type="text" id="nop_blok" name="nop_blok" required="required" class="form-control nop-blok" style="letter-spacing: 0.15em" value="">
                                    </div>
                                    @error('nop')
                                    <div class="text-danger mt-1 d-block">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                @livewire('options.pilihan-objek')
                                @include('pages.transaksi.sppt._form-control')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

</x-app-layout>
