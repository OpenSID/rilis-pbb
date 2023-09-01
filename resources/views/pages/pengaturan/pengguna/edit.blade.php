<x-app-layout title="Ubah Pengguna">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Pengaturan" active="Ubah Pengguna"></x-breadcrumbs>
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary btn-circle me-2">
                                <i class="fa fa-arrow-left"></i>
                            </a>

                            <strong class="card-title">Ubah Pengguna</strong>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('pengguna.update', encrypt($pengguna->id)) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                @include('pages.pengaturan.pengguna._form-control')
                            </form>

                            <span class="button-delete-right">
                                <!-- Tombol Hapus Data -->
                                <button type="button" class="btn btn-danger btn-circle" data-bs-toggle="modal" data-bs-target="#{{ $table }}-{{ $pengguna->id }}">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>

                                <!-- Modal Hapus Data -->
                                @include('layouts.modals.delete', ['table' => $table , 'data' => $pengguna])
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

</x-app-layout>
