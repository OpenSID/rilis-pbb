
<!-- Hapus Beberapa Data -->
<script type="text/javascript">
    $(function(e){
        // Pilih Check-All (Semua)
        $('#check-all').click(function(){
            $('.checkBoxClass').prop('checked', $(this).prop('checked'));

            if ( this.checked ) {
                $('.btn-hapus-data-dipilih').removeAttr('disabled');
            } else {
                $('.btn-hapus-data-dipilih').attr('disabled', 'disabled');
            }

            toggledeleteAllBtn();
        });

        // Pilih Tertentu dan jika dipilih semua check-all akan terpilih
        $('input[name="ids"]').change(function(){
            // Checkbox Check-All
            if($('input[name="ids"]').length == $('input[name="ids"]:checked').length){
                $('#check-all').prop('checked', true);
            }else{
                $('#check-all').prop('checked', false);
            }

            // Tombol Hapus Beberapa Data (Aktif/Tidak)
            if($('input[name="ids"]:checked').length > 0){
                $('.btn-hapus-data-dipilih').removeAttr('disabled');
            }else{
                $('.btn-hapus-data-dipilih').attr('disabled', 'disabled');
            }

            toggledeleteAllBtn();
        });

        // Jumlah data
        function toggledeleteAllBtn(){
            if($('input[name="ids"]:checked').length > 0){
                $('button#deleteAllBtn').text('Hapus '+$('input[name="ids"]:checked').length+' data yang dipilih');
            }else{
                $('button#deleteAllBtn').text('Hapus data yang dipilih');
            }
        }

        // Tombol Ya pada modal delete-selected
        $('#deleteAllSelectedRecord').click(function(e){
            e.preventDefault();
            var allids = [];

            $("input:checkbox[name=ids]:checked").each(function(){
                allids.push($(this).val());
            });

            $.ajax({
                url:"{{ route($table.'.deleteSelected') }}",
                type:"DELETE",
                data:{
                    _token:$("input[name=_token]").val(),
                    ids:allids
                },
                success:function(response){
                    $.each(allids, function(key,val){
                        $("#sid"+val).remove();
                    });

                    // Mengarahkan ke halaman index
                    window.location.replace("{{ route($table.'.index') }}");

                    $(document).ready(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Proses hapus beberapa data berhasil.',
                            showConfirmButton: false,
                            buttonsStyling: false,
                            timer: 1500,
                            timerProgressBar: true,
                        });
                    });
                }
            })
        })
    });
</script>

