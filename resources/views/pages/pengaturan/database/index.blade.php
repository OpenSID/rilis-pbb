<x-app-layout title="Database">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Pengaturan" active="Database"></x-breadcrumbs>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="container-fluid">
            <x-tab :data="$dataTabs"/>
        </div>
    </div>
@endsection
</x-app-layout>
