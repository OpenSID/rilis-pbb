<x-app-layout title="Dashboard">

    @section('content')
        <div class="col-md-2 mb-3">
            <select id="filter_periode" name="filter_periode" class="form-select filter">
                <option value="0" readonly>-- Pilih Tahun --</option>
                @foreach ($periodes as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->tahun }}
                    </option>
                @endforeach
            </select>
        </div>

        <livewire:dashboard :periodes="$periodes" :aplikasi="$aplikasi">
    @endsection

    @push('scripts')
        <script>
            $(".filter").on('change', function(){
                let periode = $('#filter_periode').val()
                console.log(periode)
                livewire.emit('setPilihTahunDashboard', periode);
            })
        </script>
    @endpush

</x-app-layout>
