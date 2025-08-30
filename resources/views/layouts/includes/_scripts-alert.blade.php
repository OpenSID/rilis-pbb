<!-- Pesan Berhasil Login -->
@if(Session::has('success-login'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!!',
            text: 'Anda Berhasil Login.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Tambah Data -->
@if(Session::has('store-success'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!!',
            text: 'Proses tambah baru berhasil.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Ubah Data -->
@if(Session::has('update-success'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!!',
            text: 'Proses ubah data berhasil.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Hapus Data -->
@if(Session::has('destroy-success'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Proses hapus data berhasil.',
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Pembayaran SPPT -->
@if(Session::has('payment-success'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!!',
            text: 'Proses pembayaran SPPT berhasil.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Batal Bayar SPPT -->
@if(Session::has('canceled-success'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Proses batal pembayaran SPPT berhasil.',
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Setor Bank -->
@if(Session::has('deposit-success'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!!',
            text: 'Berhasil melakukan setor Bank.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Batal Setor Bank -->
@if(Session::has('canceled-deposit'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Berhasil membatalkan setor Bank.',
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Berhasil Import -->
@if(Session::has('import-success'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!!',
            text: 'Data berhasil di impor.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Gagal Import -->
@if(Session::has('import-failed'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!!',
            text: 'Data gagal di impor, silakan dicek kembali data excel dan perhatikan catatan untuk impor.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Gagal Import -->
@if(Session::has('import-periode-failed'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!!',
            text: 'Data gagal di impor, periode/tahun pada Sheet Periode belum tersedia.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Berhasil Import -->
@if(Session::has('import-success'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!!',
            text: 'Data berhasil di impor.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Error Data Import Tidak Ditemukan -->
@if(Session::has('import-data-error'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'error',
            title: 'Data Tidak Ditemukan!',
            text: '{!! addslashes(session('import-data-error')) !!}',
            customClass: {
                confirmButton: 'btn btn-danger',
            },
            showConfirmButton: true,
            buttonsStyling: false,
            confirmButtonText: 'OK',
            allowOutsideClick: false,
        });
    });
</script>
@endif

<!-- Salin Data Gagal -->
@if(Session::has('salin-gagal'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!!',
            text: 'Data gagal di salin, silakan dicek kembali periode tahun ini.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

<!-- Pesan Berhasil Import -->
@if(Session::has('salin-berhasil'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!!',
            text: 'Data berhasil di salin.',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            showConfirmButton: false,
            buttonsStyling: false,
            timer: 1500,
            timerProgressBar: true,
        });
    });
</script>
@endif

@if(Session::has('action-failed'))
<script nonce="{{ csp_nonce() }}" type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!!',
            text: '{{ session('action-failed') }}',
            customClass: {
                confirmButton: 'btn btn-danger',
            },
            showConfirmButton: true,
            buttonsStyling: false,
            timerProgressBar: false,
        });
    });
</script>
@endif