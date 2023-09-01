<!-- Modal -->
<div class="modal fade" id="detil-{{ $table .'-'. $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="staticBackdropLabel">Data SPPT Tanggungan RT</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive mt-3">
                    <table id="table-detail{{ $table }}-{{ $data->id }}" class="table table-striped table-bordered width-100">
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
                        <livewire:master-data.rt.info-detail :data="$data" :wire:key="$data->id">
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
    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        document.addEventListener("DOMContentLoaded", () => {
            $('#table-detail{{ $table }}-{{ $data->id }}').DataTable({
                'destroy': true,
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                language:{
                    url: "{{ asset('build/js/bahasa.json') }}"
                },
            });
        });
    </script>
@endpush
