@include('layouts.includes._style-pdf')
@php
    $rekaps = is_array($rekaps) ? collect($rekaps) : $rekaps;
    $count_data = $rekaps->count();
    $page = $count_data / 15;
    if($page < 1){
        $page = 1;
    }

    $chunk = $rekaps->chunk(15);
@endphp

@for($i = 0; $i < $page; $i++)
    @if ($i > 0)
        <div style="page-break-before: always;"></div>
    @endif

    <table style="width:45%; float: left;">
        <tr>
            @if($logo_surat)
            <td style="width: 100px; font-family: helvetica;"><img src="{{ storage_path('app/public/pengaturan-aplikasi/' . $logo_surat) }}" alt="" width="100"></td>
            @else
            <td style="width: 100px; font-family: helvetica;"><img src="{{ public_path('build/images/opendesa/pengaturan-aplikasi/logo-surat.png') }}" alt="" width="100"></td>
            @endif
            <td valign="top" align="center" style="width: 350px; font-family: helvetica;">
            <b>DINAS PENDAPATAN DAERAH</b><br>
            <div style="font-size: 12px;"> (DISPENDA) <br>
                KABUPATEN  : {{ strtoupper($nama_kabupaten) }}<br>
                {{ strtoupper($nama_provinsi) }}
                </div>
            <br>
            <div style="font-size: 14px; font-family: helvetica;">
                <b>PELAYANAN PAJAK DAERAH <br>
                PAJAK BUMI DAN BANGUNAN (PBB-P2)</b>
            </div>
            </td>
        </tr>
    </table>

    <table style="width:45%; float: left;">
        <tr style="height: 250px;">
            <td valign="top" style="font-family: helvetica;" colspan="5">
            <b>DAFTAR PENERIMAAN HARIAN PAJAK BUMI DAN BANGUNAN</b>
            </td>
        </tr>
        <tr style="line-height: 28px;">
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 12px; width: 100px;">PROVINSI</td>
            <td style="font-size: 12px; width: 6px;">:</td>
            <td style="font-size: 12px; width: 10px;">({{ $kode_provinsi }})</td>
            <td style="font-size: 12px;">{{ $nama_provinsi }}</td>
        </tr>
        <tr>
            <td style="font-size: 12px;">KABUPATEN</td>
            <td style="font-size: 12px;">:</td>
            <td style="font-size: 12px;">({{ $kode_kabupaten }})</td>
            <td style="font-size: 12px;">{{ $nama_kabupaten }}</td>
        </tr>
        <tr>
            <td style="font-size: 12px;">KECAMATAN</td>
            <td style="font-size: 12px;">:</td>
            <td style="font-size: 12px;">({{ substr($kode_kecamatan,0,2) }})</td>
            <td style="font-size: 12px;">{{ $nama_kecamatan }}</td>
        </tr>
        <tr>
            <td style="font-size: 12px;">DESA/KELURAHAN</td>
            <td style="font-size: 12px;">:</td>
            <td style="font-size: 12px;">({{ substr($kode_desa, 1, 2) }})</td>
            <td style="font-size: 12px;">{{ $nama_desa }}</td>
        </tr>
    </table>

    <table style="width:10%; float: left; margin-top: 50px; border: 1px solid black;">
        <tr align="center">
            <td style="font-size: 12px;">
            Lembar {{ $i + 1 }}
            </td>
        </tr>
        <tr align="center">
            <td style="border: 1px solid black; font-size: 12px;">
            Untuk Desa / <br>
            Kelurahan
            </td>
        </tr>
    </table>

    <table id="tblData">
        <tr>
            <td rowspan="3" align="center">No.</td>
            <td rowspan="3" align="center">
            NOMOR BLOCK, <br>
            NOMOR URUT OP, <br>
            KODE OP
            </td>
            <td rowspan="3" align="center">
                NAMA WAJIB PAJAK
            </td>
            <td rowspan="3" align="center">
            TAHUN
            </td>
            <td colspan="5" align="center">
            JUMLAH PEMBAYARAN RUPIAH
            </td>
            <td rowspan="3" align="center" align="center">Jumlah <br> (Rp)</td>
            <td rowspan="3" align="center" align="center">STTS</td>
        </tr>
        <tr>
            <td colspan="2" align="center">PAJAK TERHUTANG PADA</td>
            <td colspan="3" align="center">SURAT TAGIHAN PAJAK</td>
        </tr>
        <tr>
            <td align="center">SPPT</td>
            <td align="center">SKP</td>
            <td align="center">Pajak</td>
            <td align="center">Denda</td>
            <td align="center">Jumlah</td>
        </tr>
        <tr>
            <td align="center">1</td>
            <td align="center">2</td>
            <td align="center">3</td>
            <td align="center">4</td>
            <td align="center">5</td>
            <td align="center">6</td>
            <td align="center">7</td>
            <td align="center">8</td>
            <td align="center">9(7+8)</td>
            <td align="center">10</td>
            <td align="center">11</td>
        </tr>

        @if (isset($chunk[$i]) && array($chunk[$i]) && count($chunk[$i]) > 0)
        @foreach ($chunk[$i] as $index => $item)
            {{ $total +=  $item->nilai_pagu_pajak }}
            <tr>
            <td align="center">{{ $index + 1 }}</td>
            <td align="center">{{ $item->nop }}</td>
            <td align="left">{{ $item->subjek_pajak->nama_subjek ?? '' }}</td>
            <td align="center">{{ $item->periode->tahun ?? '' }}</td>
            <td align="right">{{ $item->nilai_pagu_pajak == 0 ? '-' : number_format($item->nilai_pagu_pajak, 0, ".", ".") }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="right">{{ $item->nilai_pagu_pajak == 0 ? '-' : number_format($item->nilai_pagu_pajak, 0, ".", ".") }}</td>
            <td align="center">
                @if($item->status == 1)
                    <span class="badge badge-danger">Terhutang</span>
                @else
                    <span class="badge badge-success">Lunas</span>
                @endif
            </td>
            </tr>
        @endforeach

        <tr>
            <td align="center" colspan="4"><b>Jumlah</b></td>
            <td align="right">{{ $total == 0 ? '-' : number_format($total, 0, ".", ".") }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="right">{{ $total == 0 ? '-' : number_format($total, 0, ".", ".") }}</td>
            <td></td>
        </tr>
        @endif
    </table>

    <table style="width:100%; margin-top: 25px; border-collapse: collapse;">
        <tr>
            <td style="font-size: 12px; width: 190px; border: 1px solid black;" align="center">Jumlah Setoran Telah Diterima</td>
            <td style="font-size: 12px; width: 110px; border: 1px solid black;" align="center">Tanda Tangan dan <br> Cap Bank</td>
            <td style="width: 340px;">&nbsp;</td>
            <td style="font-size: 12px; width: 140px;" align="center" valign="bottom">Petugas Pemungut <br>{{ $nama_rt ?? '' }}</td>
            <td style="width: 100px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 12px; width: 40px; border: 1px solid black; padding: 8px;">
            Tanggal <br>
            ................................................................ <br>
            Nama Bank <br>
            ................................................................
            </td>
            <td style="font-size: 12px; width: 40px; border: 1px solid black;">
            &nbsp;
            </td>
            <td>
            &nbsp;
            </td>
            <td style="font-size: 12px;" align="center" valign="bottom">
            <b>{{ $nama_rayon ?? ''}}</b>
            </td>
            <td style="font-size: 12px;" align="center" valign="bottom">
            Hal: &nbsp;{{ $i + 1 }}
            </td>
        </tr>
    </table>
@endfor
