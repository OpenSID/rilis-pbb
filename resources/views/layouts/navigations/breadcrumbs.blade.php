<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ $active }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-end">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="/">Dashboard</a></li>
                            @if($navigations)
                                <li><a href="#">{{ $navigations }}</a></li>
                            @endif
                            <li class="active">{{ $active }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
