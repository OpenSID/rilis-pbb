<div>
    <div class="table-responsive mt-3">
        <table id="table-detail{{ $table }}-{{ $data->id }}" class="table table-striped table-bordered" style="width: 100%">
            <!-- Judul tabel -->
            <thead>
                <tr>
                    <th class="text-center"><small>No</small></th>
                    <th class="text-center"><small>Nama</small></th>
                    <th class="text-center"><small>RT</small></th>
                    <th class="text-center"><small>Pagu Pajak</small></th>
                    <th class="text-center"><small>Status</small> </th>
                </tr>
            </thead>

            <!-- Isi data dalam tabel -->
            <tbody>
                @foreach($info as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-start">{{ $item->subjek_pajak->nama_subjek ?? '' }}</td>
                        <td>{{ $item->nama_rt ?? '' }}</td>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($timelines->first())
        <div id="timeline">
            <hr>
            <h5 class="text-start fw-bold">Timeline Rekap Pembayaran</h5>
            <ul class="timeline">
                @foreach ($timelines as $item)
                    <li class="d-flex justify-content-between">
                        <a href="#">{{ $item->sppt->subjek_pajak->nama_subjek }} telah melunasi pajaknya</a>
                        <a href="#" class="float-right">
                            {{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_bayar)->isoFormat('D MMMM Y'); }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
