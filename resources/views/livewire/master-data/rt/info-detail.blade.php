<div>
    <tbody>
        @foreach($info as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-start">{{ $item->subjek_pajak->nama_subjek ?? '' }}</td>
                <td>{{ $item->objek_pajak->rt->nama_rt ?? '' }}</td>
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
</div>
