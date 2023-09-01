<!--  Menampilkan Datatables -->
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        $('#datatable').DataTable({
            dom: 'Pfrtip',
            searchPanes: {
                initCollapsed: true
            },
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
    });
</script>
