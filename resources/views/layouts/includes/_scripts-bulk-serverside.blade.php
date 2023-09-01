
<!-- Hapus Beberapa Data -->
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
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
        $('#datatable tbody').on('click', '.checkBoxClass', function(){
            // Checkbox Check-All
            if($('.checkBoxClass').length == $('.checkBoxClass:checked').length){
                $('#check-all').prop('checked', true);
            }else{
                $('#check-all').prop('checked', false);
            }

            // Tombol Hapus Beberapa Data (Aktif/Tidak)
            if($('.checkBoxClass:checked').length > 0){
                $('.btn-hapus-data-dipilih').removeAttr('disabled');
            }else{
                $('.btn-hapus-data-dipilih').attr('disabled', 'disabled');
            }

            toggledeleteAllBtn();
        });

        // Jumlah data
        function toggledeleteAllBtn(){
            if($('.checkBoxClass:checked').length > 0){
                $('button#deleteAllBtn').text('Hapus '+$('.checkBoxClass:checked').length+' data yang dipilih');
            }else{
                $('button#deleteAllBtn').text('Hapus data yang dipilih');
            }
        }

        // Tombol Ya pada modal delete-selected
        $('#deleteAllSelectedRecord').click(function(e){
            e.preventDefault();
            let checkbox_terpilih = $('#datatable tbody .checkBoxClass:checked')
            let allids = [];
            $.each(checkbox_terpilih, function(index,elm){
                allids.push(elm.value)
            })

            $.ajax({
                url:"{{ route($table.'.deleteSelected') }}",
                type:"DELETE",
                data:{
                    _token:$("input[name=_token]").val(),
                    ids:allids
                },
                success:function(response){
                    // Mengarahkan ke halaman index
                    window.location.replace("{{ route($table.'.index') }}");

                    document.addEventListener("DOMContentLoaded", () => {
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
                },
                error: function (request, status, error) {
                    $('.modal.show button[data-bs-dismiss=modal]').click()
                    Swal.fire({
                            icon: 'failed',
                            title: 'Gagal',
                            text: request.responseJSON['failed'],
                            showConfirmButton: true,
                            customClass: {
                                confirmButton: 'btn btn-danger',
                            },
                            buttonsStyling: false,
                            timerProgressBar: false,
                        });
                }
            })
        })
    });
</script>

