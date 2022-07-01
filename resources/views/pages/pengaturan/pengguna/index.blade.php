<x-app-layout title="Pengguna">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Pengaturan" active="Pengguna"></x-breadcrumbs>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Data pengguna</strong>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <!-- Tombol Tambah Data -->
                            <a href="{{ route('pengguna.create') }}" class="btn btn-success"><i class="fa fa-plus-circle me-2"></i>Tambah</a>

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
                                    <tr>
                                        <th class="text-end"><input type="checkbox" id="check-all"></th>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Lengkap</th>
                                        <th class="text-center">Nama Pengguna</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Foto Pengguna</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <!-- Isi data dalam tabel -->
                                <tbody>
                                    @foreach($pengguna as $index => $item)
                                        <tr id="sid{{ $item->id }}">
                                            <td class="text-center"><input type="checkbox" name="ids" class="checkBoxClass" value="{{ $item->id }}"></td>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td class="text-center">
                                                @if($item->photo)
                                                    <button class="btn image-responsive" style="background-image:url('{{ asset('storage/pengguna/' . $item->photo) }}"></button>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <!-- Tombol Ubah Data -->
                                                <a href="{{ route('pengguna.edit', encrypt($item->id)) }}" class="btn btn-primary btn-sm {{ $item->id == 1 && $demo == true ? 'd-none' : ''}}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <!-- Tombol Hapus Data -->
                                                <button type="button" class="btn btn-sm btn-danger {{ $item->id == 1 && $demo == true ? 'd-none' : ''}}" data-toggle="modal" data-target="#{{ $table }}-{{ $item->id }}">
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
