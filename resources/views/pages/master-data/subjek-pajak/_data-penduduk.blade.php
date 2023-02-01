<div class="item form-group d-flex mb-2">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_subjek">NIK / Nama Subjek Pajak<span class="">*</span></label>
    <div class="col-md-6 col-sm-6 me-2">
        @if ($this->subjek->penduduk)
        <select class="form-select" name="nama_subjek" id="nama_subjek" style="width: 100%">
            <option selected>{{ "{$this->subjek->nama_subjek} - {$this->subjek->nik}" }}</option>
        </select>
        @else
        <select class="form-select" name="nama_subjek" id="nama_subjek" style="width: 100%"></select>
        @endif
    </div>
</div>

@push('scripts')
    <!-- Select 2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#nama_subjek').select2({
                ajax: {
                    url: '{{ $url }}',
                    headers: {
                        'Authorization' : 'Bearer {{ $token }}',
                    },
                    dataType: 'json',
                    delay: 400,
                    data: function(params) {
                        return {
                            'page[number]' : params.page || 1,
                        };
                    },
                    processResults: function(response, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(response.data, function (item) {
                            return {
                                id: item.id + ' - ' + item.attributes.nama + ' - ' + item.attributes.nik,
                                text: item.attributes.nama + ' - ' + item.attributes.nik,
                            }
                            }),
                            pagination: {
                                more: (params.page * response.meta.pagination.per_page) < response.meta.pagination.total
                            },
                        };
                    },
                    cache: true
                }
            });
        })
    </script>
@endpush
