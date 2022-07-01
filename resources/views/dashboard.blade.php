<x-app-layout title="Dashboard">

    @section('content')
    <!-- Animated -->
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-flat-color-3">
                        <div class="card-body d-flex">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="count float-left">{{ $sppt_total }}</span>
                                    <span>&nbsp;Lembar</span>
                                </h3>
                                <p class="text-light mt-1 m-0">Total SPPT</p>
                            </div>
                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg ti-layers" style="float: right"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-flat-color-4">
                        <div class="card-body d-flex">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="count float-left">{{ $sppt_terhutang }}</span>
                                    <span>&nbsp;Lembar</span>
                                </h3>
                                <p class="text-light mt-1 m-0">SPPT Terhutang</p>
                            </div>
                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg ti-alert" style="float: right"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-flat-color-1">
                        <div class="card-body d-flex">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="count float-left">{{ $sppt_terbayar }}</span>
                                    <span>&nbsp;Lembar</span>
                                </h3>
                                <p class="text-light mt-1 m-0">SPPT Terbayar</p>
                            </div>
                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg ti-check-box" style="float: right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-flat-color-3">
                        <div class="card-body d-flex">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="currency float-left mr-1">Rp&nbsp;</span>
                                    <span class="count">{{ $pagu_total }}</span>
                                </h3>
                                <p class="text-light mt-1 m-0">Total Pagu</p>
                            </div>
                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg ti-money" style="float: right"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-flat-color-4">
                        <div class="card-body d-flex">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="currency float-left mr-1">Rp&nbsp;</span>
                                    <span class="count">{{ $pagu_terhutang }}</span>
                                </h3>
                                <p class="text-light mt-1 m-0">Pagu Terhutang</p>
                            </div>
                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg ti-alert" style="float: right"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-flat-color-1">
                        <div class="card-body d-flex">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="currency float-left mr-1">Rp&nbsp;</span>
                                    <span class="count">{{ $pagu_terbayar }}</span>
                                </h3>
                                <p class="text-light mt-1 m-0">Pagu Terbayar</p>
                            </div>
                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg ti-check-box" style="float: right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-flat-color-6">
                        <div class="card-body d-flex">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="count float-left">{{ $rayon }}</span>
                                    <span>&nbsp;</span>
                                </h3>
                                <p class="text-light mt-1 m-0">Rayon</p>
                            </div>
                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg ti-user" style="float: right"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-flat-color-6">
                        <div class="card-body d-flex">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="count float-left">{{ $rt }}</span>
                                    <span>&nbsp;</span>
                                </h3>
                                <p class="text-light mt-1 m-0">RT</p>
                            </div>
                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg ti-home" style="float: right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="title-header">
                                        Riwayat Pembayaran
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- <?php if (isset($riwayat_pembayaran) && is_array($riwayat_pembayaran) && count($riwayat_pembayaran) > 0): ?>
                                        <?php foreach ($riwayat_pembayaran as $key => $value): ?>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="stat-widget-five">
                                                        <div class="stat-icon dib flat-color-3">
                                                            <i class="ti-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8" style="font-size: 80%">
                                                    <?=$value['nama_wp']?>  <span class="badge badge-success float-right">Rp. <?=rupiah($value['pagu_wp'])?></span><br>
                                                    Telah bayar pada <?=tgl_indo($value['tgl_bayar'])?>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endforeach ?>
                                        <a href="<?=base_url()?>rekap_lunas" class="btn btn-info btn-block">Lihat Selengkapnya</a>
                                    <?php else: ?>
                                        Tidak ada data
                                    <?php endif ?> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="title-header">
                                        Nama Rayon
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- <?php if (isset($rayon) && is_array($rayon) && count($rayon) > 0): ?>
                                        <div class="row">
                                        <?php foreach ($rayon as $key => $value): ?>
                                                <div class="col-md-3">
                                                    <img class="user-avatar rounded-circle" src="<?=base_url()?>assets/images/admin.jpg" alt="User Avatar"><br>
                                                    <span><?=$value['nama_rayon']?></span>
                                                </div>
                                        <?php endforeach ?>
                                        </div>
                                        <a href="<?=base_url()?>rayon" class="btn btn-info btn-block">Lihat Selengkapnya</a>
                                    <?php else: ?>
                                        Tidak ada data
                                    <?php endif ?> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="title-header">
                                        Pencapaian Rayon
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- <?php if (isset($rayon) && is_array($rayon) && count($rayon) > 0): ?>
                                        <?php foreach ($rayon as $key => $value): ?>
                                            <?php
                                                // Total Bayar
                                                $query_bayar = "SELECT sum(w.pagu_wp) as total_bayar, COUNT(w.id_wp) as jumlah_wp_terbayar FROM tb_wp w
                                                                JOIN tb_rt rt ON rt.id_rt=w.id_rt_ref
                                                                WHERE rt.id_rayon_ref = ? AND w.status = ?";
                                                $result = $this->db->query($query_bayar, array($value['id_rayon'], 2))->row_array();

                                                $total_bayar = $result['total_bayar'];
                                                $jumlah_wp_terbayar = $result['jumlah_wp_terbayar'];
                                                $total_pagu = $value['total_pagu'];

                                                // Total Kekurangan
                                                $total_kekurangan = $total_pagu-$total_bayar;

                                                if ($total_bayar > 0 && $total_pagu > 0) {
                                                    $persen_pagu_terpenuhi = round($total_bayar/$total_pagu*100, 2);
                                                } else {
                                                    $persen_pagu_terpenuhi = 0;
                                                }
                                             ?>
                                            <?=$value['nama_rayon']?> <span class="badge badge-default float-right"><?=$jumlah_wp_terbayar?>/<?=$value['jumlah_wp']?></span><br>
                                            <div class="progress">
                                              <div class="progress-bar" role="progressbar" style="width: <?=$persen_pagu_terpenuhi?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?=$persen_pagu_terpenuhi?>%</div>
                                            </div>
                                            <hr>
                                        <?php endforeach ?>
                                        <a href="<?=base_url()?>rayon" class="btn btn-info btn-block">Lihat Selengkapnya</a>
                                    <?php else: ?>
                                        Tidak ada data
                                    <?php endif ?> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <!-- .animated -->
    @endsection

</x-app-layout>
