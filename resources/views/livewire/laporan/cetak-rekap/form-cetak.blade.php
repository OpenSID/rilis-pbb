<div>
    @foreach ($btn_menus as $item)
        <button wire:click="selectMenu({{ $item['id'] }})" class="btn {{ $item['id'] == $selectedMenu ? 'btn-success-detail' : 'btn-default' }} " id="filter_penerimaan_rayon">{{ $item['title'] }}</button>
    @endforeach

    <hr>

    @if($selectedMenu == 1)
        @include('pages.laporan.cetak-rekap._rayon')
        <div class="item form-group mb-2">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="rt_id">Wilayah </label>
            <div class="col-md-12 col-sm-12">
                <select name="rt_id" id="rt_id" wire:model="selectedRT" required="required" class="form-select " data-width="100%">
                    <option value=''>-- Pilih Wilayah --</option>
                    @foreach($rts as $rt)
                        <option value="{{ $rt->id }}" >{{ $rt->nama_rt}}</option>
                    @endforeach
                </select>
            </div>
            @error('rt_id')
            <div class="text-danger mt-1 d-block">{{ $message }}</div>
            @enderror
        </div>
    @elseif($selectedMenu == 2)
        @include('pages.laporan.cetak-rekap._rayon')
        <div class="form-group area mb-3">
            <label class="col-form-label col-md-3 col-sm-3 label-align">Tahun </label>
            <select class="form-control select2" wire:model="selectedTahun">
                <option value="">-- Pilih Tahun --</option>
                @foreach($years as $item)
                    <option value="{{ $item->tahun }}" >{{ $item->tahun}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group area mb-3">
            <label class="col-form-label col-md-3 col-sm-3 label-align">Bulan </label>
            <select class="form-control select2" wire:model="selectedBulan">
                <option value="">-- Pilih Bulan --</option>
                @foreach($months as $item)
                    <option value="{{ $item['id'] }}" >{{ $item['bulan']}}</option>
                @endforeach
            </select>
        </div>
    @elseif($selectedMenu == 3)
        @include('pages.laporan.cetak-rekap._rayon')
        <div class="form-group area mb-3">
            <label class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Bayar </label>
            <input type="text" wire:model="tanggal_rayon" id="tanggal_rayon" name="tanggal_rayon" value="" class="form-control" placeholder="Pilih Tanggal Bayar"/>
        </div>
    @elseif($selectedMenu == 4)
        <div class="form-group area mb-3">
            <label class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Bayar </label>
            <input type="text" wire:model="tanggal_bayar" id="tanggal_bayar" name="tanggal_bayar" value="" class="form-control" placeholder="Pilih Tanggal Bayar"/>
        </div>
    @elseif($selectedMenu == 5)
        <div class="form-group area mb-3">
            <label class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Setor </label>
            <input type="text" wire:model="tanggal_setor" id="tanggal_setor" name="tanggal_setor" value="" class="form-control" placeholder="Pilih Tanggal Setor"/>
        </div>
    @endif

    <div class="">
        @error('message')
            <div class="text-danger mt-2">
                {{ $message }}
            </div>
            <br/>
        @enderror
    </div>

    <div class="">
        <button wire:click="Sortir" type="button" class="btn btn-info-detail btn_filter"><i class="fa fa-filter"></i> Sortir</button>
        <a href="{{ $tombolUnduh == 'disabled' ? '#' : route('cetak-rekap.downloadPdf', $selectedMenu . '-' . $selectedRayon . '-' . $tahun. '-'. encrypt($unduhData)) }}" target="_blank" class="btn btn-success-detail btn-block {{ $tombolUnduh }}">
            <i class="fa fa-download"></i> Unduh
        </a>
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="/vendors/moment/moment.js"></script>

    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        /** Pilih Tanggal Bayar Berdasarkan Rayon */
        Livewire.on('TanggalRayon', () => {
            $('input[name="tanggal_rayon"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="tanggal_rayon"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            //mengirimkan ke livewire
            $('#tanggal_rayon').on('apply.daterangepicker', function(ev, picker){
                @this.set('tanggal_rayon', ev.target.value);
            });

            $('input[name="tanggal_rayon"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });

        /** Pilih Tanggal Bayar */
        Livewire.on('TanggalBayar', () => {
            $('input[name="tanggal_bayar"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="tanggal_bayar"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            //mengirimkan ke livewire
            $('#tanggal_bayar').on('apply.daterangepicker', function(ev, picker){
                @this.set('tanggal_bayar', ev.target.value);
            });

            $('input[name="tanggal_bayar"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });

        /** Pilih Tanggal Setor */
        Livewire.on('TanggalSetor', () => {
            $('input[name="tanggal_setor"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="tanggal_setor"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            //mengirimkan ke livewire
            $('#tanggal_setor').on('apply.daterangepicker', function(ev, picker){
                @this.set('tanggal_setor', ev.target.value);
            });

            $('input[name="tanggal_setor"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });
    </script>
@endpush
