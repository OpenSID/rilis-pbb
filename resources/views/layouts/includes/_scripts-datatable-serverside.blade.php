<!--  Menampilkan Datatables -->
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        var table = $('#datatable').DataTable({
            order: [],
            processing: true,
            serverSide: true,
            ajax: "{{ route($table.'.index')}}",
            columns: dataColumn, //didaftarkan di index
            destroy: true,
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: true,
            language:{
                url: "{{ asset('build/js/bahasa.json') }}"
            },
        });

        $(".filter").on('change', function(){
            let _column , _periode, _value
            table.search('').columns().search('')
            $(".filter").each(function(){
                _value = $(this).val()
                if (!isEmpty(_value)){
                    _column = $(this).data('column')
                    table.columns(_column).search(_value)
                }
            })
            table.draw()
        })
    });
</script>
