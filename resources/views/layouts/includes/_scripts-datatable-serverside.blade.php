<!--  Scripts cdn Datatables -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.13.1/sorting/formatted-numbers.js"></script>

<!--  Menampilkan Datatables -->
<script type="text/javascript">
    $(document).ready( function () {
        var table = $('#datatable').DataTable({
            order: [[1, "desc"]],
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
            var periode = table.search( this.value ).draw();
        })
    });
</script>
