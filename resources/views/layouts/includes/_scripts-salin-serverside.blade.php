
<!-- Salin Beberapa Data -->
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        // Pilih Check-All (Semua)
        $('#check-all').click(function(){
            $('.checkBoxClass').prop('checked', $(this).prop('checked'));

            if ( this.checked ) {
                $('.btn-salin-data-dipilih').removeAttr('disabled');
            } else {
                $('.btn-salin-data-dipilih').attr('disabled', 'disabled');
            }

            togglesalinSelectBtn();
        });

        // Pilih Tertentu dan jika dipilih semua check-all akan terpilih
        $('#datatable tbody').on('click', '.checkBoxClass', function(){
            // Checkbox Check-All
            if($('.checkBoxClass').length == $('.checkBoxClass:checked').length){
                $('#check-all').prop('checked', true);
            }else{
                $('#check-all').prop('checked', false);
            }

            // Tombol Salin Beberapa Data (Aktif/Tidak)
            if($('.checkBoxClass:checked').length > 0){
                $('.btn-salin-data-dipilih').removeAttr('disabled');
            }else{
                $('.btn-salin-data-dipilih').attr('disabled', 'disabled');
            }

            togglesalinSelectBtn();
        });

        // Jumlah data
        function togglesalinSelectBtn(){
            if($('.checkBoxClass:checked').length > 0){
                $('button#salinSelectBtn').text('Salin '+$('.checkBoxClass:checked').length+' data yang dipilih');
            }else{
                $('button#salinSelectBtn').text('Salin data yang dipilih');
            }
        }

        // Tombol Ya pada modal salin-selected
        $('#salinAllSelectedRecord').click(function(e){
            e.preventDefault();
            let checkbox_terpilih = $('#datatable tbody .checkBoxClass:checked')
            let allids = [];
            $.each(checkbox_terpilih, function(index,elm){
                allids.push(elm.value)
            })

            $.ajax({
                url:"{{ route($table.'.salinTerpilih') }}",
                type:"POST",
                data:{
                    _token:$("input[name=_token]").val(),
                    ids:allids
                },
                success:function(response){
                    // Mengarahkan ke halaman index
                    window.location.replace("{{ route($table.'.index') }}");
                }
            })
        })
    });
</script>

