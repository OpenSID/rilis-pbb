<x-app-layout title="{{ ucwords($table) }}">

    @section('breadcrumbs')
        <x-breadcrumbs navigations="Transaksi" active="{{ ucwords($table) }}"></x-breadcrumbs>
    @endsection

    @section('content')
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{ ucwords($table) }}</strong>
                        </div>

                        <div class="card-body">
                            <form action="{{ route($table.'.store') }}" method="post">
                                @csrf
                                @include('pages.transaksi.pembayaran._form-control')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

</x-app-layout>
