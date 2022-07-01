@extends('layouts.includes.header', ['favicon' => $favicon])

@section('body')

<!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <x-sidebar></x-sidebar>
    </aside>
<!-- /#left-panel -->

<!-- Right Panel -->
    <div id="right-panel" class="right-panel">

    <!-- Header-->
        <x-navbar></x-navbar>
    <!-- /#header -->

    <!-- Breadcrumbs-->
        @yield('breadcrumbs')
    <!-- /.breadcrumbs-->

    <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
    <!-- /.content -->
    <div class="clearfix"></div>

    <!-- Footer -->
        @include('layouts.includes.footer')
    <!-- /.footer -->

    <!-- Scripts -->
        @include('layouts.includes.scripts')
    <!-- /.scripts -->

    </div>
<!-- /#right-panel -->

@endsection
