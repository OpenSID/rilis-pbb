<!-- Modal -->
<div class="modal fade" id="detil-{{ $table .'-'. $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="staticBackdropLabel">Data Objek Pajak</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive mt-3">
                    <table id="table-detail{{ $table }}-{{ $data->id }}" class="table table-striped table-bordered" style="width: 100%">
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
                            </tr>
                        </thead>

                        <!-- Isi data dalam tabel -->
                        <tbody>
                            @foreach($data->objek_details as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-start">
                                        @if($item->kategori == 1)
                                            Bumi
                                        @else
                                            Bangunan
                                        @endif
                                    </td>
                                    <td>{{ number_format($item->luas_objek_pajak) }}</td>
                                    <td>{{ $item->klas }}</td>
                                    <td class="text-end">{{ number_format($item->njop, 0, ".", ".") }}</td>
                                    <td class="text-end">{{ number_format($item->total_njop, 0, ".", ".") }}</td>
                                    <td>{{ $item->periode->tahun }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!--  Datatables -->
    @include('layouts.includes._scripts-datatable')

    <!--  Menampilkan Datatables -->
    <script type="text/javascript">
        $(document).ready( function () {
            $('#table-detail{{ $table }}-{{ $data->id }}').DataTable();
        });
    </script>
@endpush
