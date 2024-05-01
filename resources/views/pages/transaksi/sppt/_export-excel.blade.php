<table id="datatable" class="table table-striped table-bordered datatable">
    <!-- Judul tabel -->
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">NOP</th>
            <th class="text-center">Letak Objek Pajak</th>
            <th class="text-center">Kode Blok</th>
            <th class="text-center">Rukun Tetangga (RT)</th>
            <th class="text-center">Alamat Objek Pajak</th>
            <th class="text-center">Nama Wajib Pajak</th>
            <th class="text-center">Alamat Subjek Pajak</th>
            <th class="text-center">Kategori Subjek Pajak</th>
            <th class="text-center">NPWP</th>
            <th class="text-center">Luas Objek Pajak Bumi</th>
            <th class="text-center">Luas Objek Pajak Bangunan</th>
            <th class="text-center">Klas Objek Pajak Bumi</th>
            <th class="text-center">Klas Objek Pajak Bangunan</th>
            <th class="text-center">NJOP Objek Pajak Bumi</th>
            <th class="text-center">NJOP Objek Pajak Bangunan</th>
            <th class="text-center">Total NJOP Objek Pajak Bumi</th>
            <th class="text-center">Total NJOP Objek Pajak Bangunan</th>
            <th class="text-center">Pagu Pajak</th>
            <th class="text-center">Status</th>
            <th class="text-center">Nama {{ ucwords($sebutan_rayon) }}</th>
            <th class="text-center">Tahun</th>
        </tr>
    </thead>

    <!-- Isi data dalam tabel -->
    <tbody>
        @foreach($sppts as $index => $item)
            @if (! $item->objek_pajak)
                @continue
            @endif
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nop }}</td>
                <td class="text-center">{{ $item->objek_pajak?->letak_objek ?? '' }}</td>
                <td class="text-center">{{ $item->objek_pajak?->kode_blok ?? '' }}</td>
                <td class="text-center">{{ $item->objek_pajak?->rt->nama_rt ?? '' }}</td>
                <td class="text-center">{{ $item->objek_pajak?->alamat_objek ?? '' }}</td>
                <td>{{ $item->subjek_pajak->nama_subjek ?? '' }}</td>
                <td class="text-center">{{ $item->subjek_pajak->alamat_subjek ?? '' }}</td>
                <td class="text-center">
                    @php
                        $kategori = $item->subjek_pajak->kategori ?? '';
                        $hasil = '';
                        if($kategori == ''){
                            $hasil = '';
                        }else if($kategori == 1){
                            $hasil = 'Penduduk';
                        }else if($kategori == 2){
                            $hasil = 'Luar Penduduk';
                        }else if($kategori == 3){
                            $hasil = 'Badan Penduduk';
                        }
                    @endphp
                    {{ $hasil }}
                </td>
                <td class="text-center">{{ $item->subjek_pajak->npwp ?? '' }}</td>
                <td class="text-center">
                    {{ collect($item->objek_pajak?->objek_details)->where('kategori', 1)->sum('luas_objek_pajak') }}
                </td>
                <td class="text-center">
                    {{ collect($item->objek_pajak?->objek_details)->where('kategori', 2)->sum('luas_objek_pajak') }}
                </td>
                <td class="text-center">
                    {{ collect($item->objek_pajak?->objek_details)->where('kategori', 1)->first()?->klas }}
                </td>
                <td class="text-center">
                    {{ collect($item->objek_pajak?->objek_details)->where('kategori', 2)->first()?->klas }}
                </td>
                <td class="text-center">
                    {{ collect($item->objek_pajak?->objek_details)->where('kategori', 1)->first()?->njop }}
                </td>
                <td class="text-center">
                    {{ collect($item->objek_pajak?->objek_details)->where('kategori', 2)->first()?->njop }}
                </td>
                <td class="text-center">
                    {{ collect($item->objek_pajak?->objek_details)->where('kategori', 1)->sum('total_njop') }}
                </td>
                <td class="text-center">
                    {{ collect($item->objek_pajak?->objek_details)->where('kategori', 2)->sum('total_njop') }}
                </td>
                <td class="text-end">
                    {{ $item->nilai_pagu_pajak }}
                </td>
                <td class="text-center">
                    @if($item->status == 1)
                        <span class="badge badge-danger">Terhutang</span>
                    @else
                        <span class="badge badge-success">Lunas</span>
                    @endif
                </td>
                <td class="text-center">{{ $item->objek_pajak?->rt->rayon->nama_rayon ?? '' }}</td>
                <td class="text-center">{{ $item->periode->tahun ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
