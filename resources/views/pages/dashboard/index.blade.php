<x-app-layout title="Dashboard">

    @section('content')
    <!-- Animated -->
        <div class="animated fadeIn">
            <!-- boxCardCounts -->
            <div class="row">
                @foreach ($boxCardCounts as $item)
                    <div class="col-6 col-md-4 mb-3">
                        <div class="eq-height">
                            <div class="card-body text-white {{ $item['color'] }} d-flex justify-content-between">
                                <div class="card-left pt-1 float-left">
                                    <h3 class="mb-0 fw-r">
                                        @if($item['currency'])
                                            <span class="currency float-left mr-1">{{ $item['currency'] }}&nbsp;</span> <br>
                                        @endif

                                        <span class="{{ ($item['count'] < 1000 ? 'count' : '') }} float-left">{{ number_format($item['count'], 0, ".", ".") }}</span>

                                        @if($item['description'])
                                            <small>{{ $item['description'] }}</small>
                                        @endif
                                    </h3>
                                    <p class="text-light mt-1 m-0">{{ $item['title'] }}</p>
                                </div>
                                <div class="card-right float-right text-right">
                                    <i class="icon fade-5 icon-lg {{ $item['icon'] }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- boxCardSummaries -->
            <div class="row">
                @foreach ($boxCardSummaries as $summary)
                    <div class="col-12 col-md-4 mb-3">
                        <div class="eq-height">
                            <div class="card-header bg-white">
                                <div class="title-header">
                                    {{ $summary['title'] }}
                                </div>
                            </div>
                            <div class="card card-body card-body-custom">
                                @include('pages.dashboard._summary')

                                @if($summary['link'])
                                    <div class="d-grid gap-2 col-md-12 mx-auto mt-auto">
                                        <a href="{{ route($summary['link']) }}" class="btn btn-info-detail btn-block">Lihat Selengkapnya</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    <!-- .animated -->
    @endsection

</x-app-layout>
