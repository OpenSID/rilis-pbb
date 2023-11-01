<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Cadangan Database ke {{ pbb_version() }}</strong>
            </div>
            <div class="card-body">
                <form action="{{route('database.update', 1)}}" method="post">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <span>Proses ini untuk membuat cadangan berkas dan database Aplikasi PBB.</span>

                    @if (session('active_tab') == 'backup')
                        @if (session()->has('message-success'))
                            <div class="text-center alert alert-success">
                                {{ session('message-success') }}
                            </div>
                        @elseif(session()->has('message-failed'))
                            <div class="text-center alert alert-danger">
                                {{ session('message-failed') }}
                            </div>
                        @endif
                    @endif
                    <div class="mt-2">
                        <button type="submit" value="database" name="database" class="btn btn-primary">Database</button>
                        <button type="submit" value="file" name="file" class="btn btn-danger">Berkas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
