<div>
    <table id="datatable" class="table table-striped table-bordered datatable">
        <!-- Judul tabel -->
        <thead>
            <tr>
                <th class="text-end"><input type="checkbox" id="check-all"></th>
                <th class="text-center">No</th>
                <th class="text-center">NOP</th>
                <th class="text-center">Nama Wajib Pajak</th>
                <th class="text-center">Pagu Pajak</th>
                <th class="text-center">Status</th>
                <th class="text-center">Tahun</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <!-- Isi data dalam tabel -->
        <tbody>
            @foreach($sppts as $index => $item)
                <tr id="sid{{ $item->id }}" class="{{ $item->subjek_pajak->nama_subjek ?? 'bg-warning' }}">
                    <td class="text-center"><input type="checkbox" name="ids" class="checkBoxClass" value="{{ $item->id }}"></td>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nop }}</td>
                    <td>{{ $item->subjek_pajak->nama_subjek ?? '' }}</td>
                    <td class="text-end">
                        Rp. {{ $item->nilai_pagu_pajak == 0 ? '-' : number_format($item->nilai_pagu_pajak, 0, ".", ".") }}
                    </td>
                    <td class="text-center">
                        @if($item->status == 1)
                            <span class="badge badge-danger">Terhutang</span>
                        @else
                            <span class="badge badge-success">Lunas</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->periode->tahun ?? '' }}</td>

                    <td class="text-center">
                        <!-- Tombol Ubah Data -->
                        <a href="{{ route($table.'.edit', encrypt($item->id)) }}" class="btn btn-primary btn-sm {{ $item->status == 2 ? 'd-none' : '' }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Data {{ strtoupper($table) }}">
                            <i class="fa fa-pencil"></i>
                        </a>

                        <!-- Tombol Hapus Data -->
                        <button type="button" class="btn btn-sm btn-danger {{ $item->status == 2 ? 'd-none' : '' }}" data-toggle="modal" data-target="#{{ $table .'-'. $item->id }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data {{ strtoupper($table) }}">
                           <i class="fa fa-trash"></i>
                        </button>

                        <!-- Modal Hapus Data -->
                        @include('layouts.modals.delete', ['table' => $table , 'data' => $item])

                        <!-- Tombol Batal Bayar -->
                        <button type="button" class="btn btn-sm btn-danger {{ $item->status == 2 ? '' : 'd-none' }}" data-toggle="modal" data-target="#pembayaran-{{ $item->id }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Batal Bayar {{ strtoupper($table) }}">
                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                        </button>

                        <!-- Modal Hapus Data -->
                        @include('layouts.modals.batal-bayar', ['table' => 'pembayaran' , 'data' => $item])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @push('scripts')
        @include('layouts.includes._scripts-datatable')
    @endpush
</div>


