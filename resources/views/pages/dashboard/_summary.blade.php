@if($summary['title'] == "Riwayat Pembayaran")
    @foreach($summary['content'] as $index => $item)
        <div class="row">
            <div class="col-md-6">
                <div class="stat-icon dib flat-color-3">
                    <i class="ti-user"></i>
                </div>
                <br>
                {{ $item->sppt->subjek_pajak->nama_subjek ?? ''}}
            </div>
            <div class="col-md-6" style="font-size: 80%">
                <span class="badge badge-success float-right">Rp. {{ $item->nilai_pagu_pajak == 0 ? '-' : number_format($item->nilai_pagu_pajak, 0, ".", ".") }}</span><br>
                Telah bayar pada <br>
                {{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_bayar)->isoFormat('D MMMM Y'); }}
            </div>
        </div>
        <hr>
    @endforeach
@endif

@if($summary['title'] == "Nama " . ucwords(str_replace('-', ' ', $aplikasi['sebutan_rayon'])))
    <div class="row">
        @foreach($summary['content'] as $index => $item)
            <div class="col-md-4 text-center mb-2">
                <img class="user-avatar rounded-circle" src="{{asset('/build/images/opendesa/pengaturan-aplikasi/pengguna.png')}}" alt="foto-pengguna" height="42px"><br>
                <span>{{ $item->nama_rayon ?? '' }}</span>
            </div>
        @endforeach
    </div>
@endif

@if($summary['title'] == "Pencapaian " . ucwords(str_replace('-', ' ', $aplikasi['sebutan_rayon'])))
    @foreach($summary['content'] as $index => $item)
        <div class="d-flex justify-content-between">
            <span>{{ $item->nama_rayon ?? '' }}</span>
            @if ($item->count_pagu)
                <span class="fw-bold" style="font-size: 90%">{{ $item->count_bayar ?? 0 }}/{{ $item->count_pagu }}</span>
            @endif
        </div>
        <div class="progress">
            <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                style="width: {{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}%;"
                aria-valuenow="{{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}" aria-valuemin="0" aria-valuemax="100">
                {{ $item->total_bayar == 0 ? 0 : number_format(($item->total_bayar/$item->total_pagu)*100) }}%
            </div>
        </div>
        <hr>
    @endforeach
@endif

