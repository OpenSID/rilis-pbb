<div>
    <div class="d-flex justify-content-between">
        <span class="fw-bold">Detil Objek Pajak</span>

        <!-- Tombol Tambah Data -->
        <button wire:click="TambahDetail()" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-detail-objek"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Data Detil {{ ucwords(str_replace('-', ' ', $table )) }}">
            <i class="fa fa-plus-circle"></i>
        </button>
    </div>

    <!-- Modal Product-->
    <div class="modal fade" wire:ignore.self id="modal-detail-objek" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-2">
        <livewire:master-data.objek-pajak.modal-detail>
    </div>


    <div class="table-responsive mt-3">
        <table id="datatable" class="table table-striped table-bordered" style="width: 100%">
            <!-- Judul tabel -->
            <thead>
                <tr>
                    <th class="text-center"><small>No</small></th>
                    <th class="text-center"><small>Objek Pajak</small></th>
                    <th class="text-center"><small>Luas (m<sup>2</sup>)</small></th>
                    <th class="text-center"><small>Klas</small></th>
                    <th class="text-center"><small>NJOP PER m<sup>2</sup> (Rp.)</small> </th>
                    <th class="text-center"><small>Total NJOP (Rp.)</small></th>
                    <th class="text-center"><small>Tahun</small></th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <!-- Isi data dalam tabel -->
            <tbody>
                @foreach($objek_details as $index => $item)
                    <tr>
                        <td class="text-center {{ $item->objek_pajak_id == 0 ? "text-primary" : "" }}">{{ $index + 1 }}</td>
                        <td class="text-start {{ $item->objek_pajak_id == 0 ? "text-primary" : "" }}">
                            @if($item->kategori == 1)
                                Bumi
                            @else
                                Bangunan
                            @endif
                        </td>
                        <td class="text-center {{ $item->objek_pajak_id == 0 ? "text-primary" : "" }}">{{ number_format($item->luas_objek_pajak) }}</td>
                        <td class="text-center {{ $item->objek_pajak_id == 0 ? "text-primary" : "" }}">{{ $item->klas }}</td>
                        <td class="text-end {{ $item->objek_pajak_id == 0 ? "text-primary" : "" }}">{{ number_format($item->njop, 0, ".", ".") }}</td>
                        <td class="text-end {{ $item->objek_pajak_id == 0 ? "text-primary" : "" }}">{{ number_format($item->total_njop, 0, ".", ".") }}</td>
                        <td class="text-center {{ $item->objek_pajak_id == 0 ? "text-primary" : "" }}">{{ $item->periode->tahun ?? '' }}</td>
                        <td class="text-center">
                            <button wire:click="removeListDetail({{ $item->id }})" type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data {{ ucwords(str_replace('-', ' ', $table )) }}">
                               <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    @include('layouts.includes._scripts-datatable')
@endpush

