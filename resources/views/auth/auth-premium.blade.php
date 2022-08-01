<x-app-layout title="{{ ucwords(str_replace('-', ' ', $title )) }}">

@section('content')
<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12 vh-100">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">{{ ucwords(str_replace('-', ' ', $title )) }}</strong>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        <span>{{ $info }}</span><br>
                        @foreach ($info_detail as $item)
                            <span>{{ $item['value'] }}<a href="{{ $item['link'] ?? "" }}" target="_blank">{{ $item['alias'] ? " ". $item['alias'] : "" }}</a>.</span><br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

</x-app-layout>
