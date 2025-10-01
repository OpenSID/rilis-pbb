<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_subjek">NIK / Nama Subjek Pajak<span
            class="">*</span></label>
    <div class="col-md-6 col-sm-6 me-2">
        @if ($this->subjek->penduduk)
            <select class="form-select width-100" name="nama_subjek" id="nama_subjek">
                <option selected>{{ "{$this->subjek->nama_subjek} - {$this->subjek->nik}" }}</option>
            </select>
        @else
            <select class="form-select  width-100" name="nama_subjek" id="nama_subjek"></select>
        @endif
    </div>
</div>

@push('scripts')
    <!-- Select 2 -->
    <script nonce="{{ csp_nonce() }}">
        document.addEventListener("DOMContentLoaded", () => {
            $('#nama_subjek').select2({
                width: '100%',
                ajax: {
                    url: '{{ $url }}',
                    headers: {
                        'Authorization': 'Bearer {{ $token }}',
                    },
                    dataType: 'json',
                    delay: 400,
                    data: function(params) {
                        return {
                            'page[number]': params.page || 1,
                            'filter[nama]': params.term,
                        };
                    },
                    processResults: function(response, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(response.data, function(item) {
                                return {
                                    id: item.id + ' - ' + item.attributes.nama + ' - ' + item
                                        .attributes.nik,
                                    text: item.attributes.nama + ' - ' + item.attributes.nik,
                                }
                            }),
                            pagination: {
                                more: (params.page * response.meta.pagination.per_page) < response.meta
                                    .pagination.total
                            },
                        };
                    },
                    cache: true
                }
            });
        })
    </script>
@endpush
