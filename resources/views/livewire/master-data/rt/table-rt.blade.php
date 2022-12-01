<div>
    <table id="datatable" class="table table-striped table-bordered datatable">
        <!-- Judul tabel -->
        <thead>
            <tr role="row" class="odd">
                <th class="text-center"><input type="checkbox" id="check-all"></th>
                <th class="text-center">No</th>
                <th class="text-center">Nama RT</th>
                <th class="text-center">Nama {{ucwords(str_replace('-', ' ', $aplikasi['sebutan_rayon'] )) }}</th>
                <th class="text-center">Total Pagu</th>
                <th class="text-center">Total Bayar</th>
                <th class="text-center">Kekurangan</th>
                <th class="text-center">Terpenuhi</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <!-- Isi data dalam tabel -->
        <tbody>
            @foreach($rts as $index => $item)
                <tr id="sid{{ $item->id }}" class="{{ $item->rayon->nama_rayon ?? 'bg-warning'}}">
                    <td class="text-center table-align"><input type="checkbox" name="ids" class="checkBoxClass" value="{{ $item->id }}"></td>
                    <td class="text-center table-align">{{ $index + 1 }}</td>
                    <td class="table-align">{{ $item->nama_rt }}</td>
                    <td class="table-align">{{ $item->rayon->nama_rayon ?? ''}}</td>
                    <td class="text-end table-align">
                        {{ $item->total_pagu == 0 ? '-' : 'Rp. '.number_format($item->total_pagu, 0, ".", ".") }}
                    </td>
                    <td class="text-end text-success table-align">
                        {{ $item->total_bayar == 0 ? '-' : 'Rp. '.number_format($item->total_bayar, 0, ".", ".") }}
                    </td>
                    <td class="text-end text-danger table-align">
                        {{ ($item->total_pagu - $item->total_bayar) == 0 ? '-' : 'Rp. '.number_format(($item->total_pagu - $item->total_bayar), 0, ".", ".") }}
                    </td>
                    <td class="table-align">
                        <div class="progress">
                            <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                style="width: {{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}%;"
                                aria-valuenow="{{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}%
                            </div>
                        </div>
                    </td>

                    <td class="text-center table-align">
                        <!-- Tombol Data Detail -->
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detil-{{ $table .'-'. $item->id }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Data Detil {{ ucwords(str_replace('-', ' ', $table )) }}">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </button>

                        <!-- Modal Tabel Data Detail -->
                        @include('pages.master-data.rt._modal-info', ['table' => $table , 'data' => $item])

                        <!-- Tombol Ubah Data -->
                        <a href="{{ route($table.'.edit', encrypt($item->id)) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil"></i>
                        </a>

                        <!-- Tombol Hapus Data -->
                        <button type="button" class="btn btn-sm btn-danger mt-1" data-toggle="modal" data-target="#{{ $table }}-{{ $item->id }}">
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
