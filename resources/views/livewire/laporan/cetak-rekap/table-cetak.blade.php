<div>
    <table id="table-rekap" class="table table-striped table-bordered datatable">
        <!-- Judul tabel -->
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nomor SPPT</th>
                <th class="text-center">Nama Wajib Pajak</th>
                <th class="text-center">Nama {{ ucwords(str_replace('-', ' ', $aplikasi['sebutan_rayon'] )) }}</th>
                <th class="text-center">RT</th>
                <th class="text-center">Pagu Pajak</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>

        <!-- Isi data dalam tabel -->
        <tbody>
            @foreach($dataTables as $index => $item)
                <tr>
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

@push('scripts')
    <!--  Datatables -->
    @include('layouts.includes._scripts-datatable')

    <script nonce="{{ csp_nonce() }}">
        Livewire.onLoad((e) => {
            $('#table-rekap').DataTable({
                'destroy': true,
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
            });
        })

        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.processed', (message, component) => {
                $('#table-rekap').DataTable({
                    'destroy': true,
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true,
                }).draw();
            })
            Livewire.hook('message.sent', (message, component) => {
                $('#table-rekap').DataTable({
                    'destroy': true,
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true,
                }).destroy();
            })
        });
    </script>
@endpush
