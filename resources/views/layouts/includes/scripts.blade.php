<!-- Skrip jquery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>

<!--  Grafik js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

<!--Flot Chart-->
<script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

<!-- Select 2 -->
<script src="{{asset('/vendors/select2/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Livewire -->
<livewire:scripts>

<!-- Pesan Sukses -->
<script src="{{asset('/vendors/sweetalert2/sweetalert2.all.min.js')}}"></script>
@include('layouts.includes._scripts-alert')

<!-- Skrip pada halaman tertentu -->
@stack('scripts')

<!-- lokal -->
<script src="{{asset('/themes/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/build/js/app.js')}}"></script>

<script>
    /** Start Modal Filter */
    window.addEventListener('closeModalObjekPajakDetail', event => {
        $("#modal-detail-objek").modal('hide');
    })

    window.addEventListener('openModalObjekPajakDetail', event => {
        $("#modal-detail-objek").modal('show');
    })
</script>
