<div>
    <table id="datatable" class="table table-striped table-bordered datatable">
        <!-- Judul tabel -->
        <thead>
            <tr>
                <th class="text-center"><input type="checkbox" id="check-all"></th>
                <th class="text-center">No</th>
                <th class="text-center">Nama {{ ucwords(str_replace('-', ' ', $title )) }}</th>
                <th class="text-center">Total Pagu</th>
                <th class="text-center">Total Bayar</th>
                <th class="text-center">Kekurangan</th>
                <th class="text-center">Terpenuhi</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <!-- Isi data dalam tabel -->
        <tbody>
            @foreach($rayons as $index => $item)
                <tr id="sid{{ $item->id }}">
                    <td class="text-center"><input type="checkbox" name="ids" class="checkBoxClass" value="{{ $item->id }}"></td>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_rayon }}</td>
                    <td class="text-end">
                        {{ $item->total_pagu == 0 ? '-' : 'Rp. '.number_format($item->total_pagu, 0, ".", ".") }}
                    </td>
                    <td class="text-end text-success">
                        {{ $item->total_bayar == 0 ? '-' : 'Rp. '.number_format($item->total_bayar, 0, ".", ".") }}
                    </td>
                    <td class="text-end text-danger">
                        {{ ($item->total_pagu - $item->total_bayar) == 0 ? '-' : 'Rp. '.number_format(($item->total_pagu - $item->total_bayar), 0, ".", ".") }}
                    </td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar bg-success progress-bar-striped width-{{ $item->total_bayar == 0 ? 0 : ceil(($item->total_bayar/$item->total_pagu)*100) }}" role="progressbar"
                                aria-valuenow="{{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}%
                            </div>
                        </div>
                    </td>

                    <td class="text-center">
                        <!-- Tombol Data Detail -->
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detil-{{ $table .'-'. $item->id }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Data Detil {{ ucwords(str_replace('-', ' ', $title )) }}">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </button>

                        <!-- Modal Tabel Data Detail -->
                        @include('pages.master-data.rayon._modal-info', ['table' => $table , 'data' => $item])

                        <!-- Tombol Ubah Data -->
                        <a href="{{ route($table.'.edit', encrypt($item->id)) }}" class="btn btn-primary btn-sm"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Data {{ ucwords(str_replace('-', ' ', $title )) }}">
                            <i class="fa fa-pencil"></i>
                        </a>

                        <!-- Tombol Hapus Data -->
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#{{ $table }}-{{ $item->id }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data {{ ucwords(str_replace('-', ' ', $title )) }}">
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
