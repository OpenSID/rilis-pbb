<x-app-layout title="Duplikasi Data">

@section('breadcrumbs')
    <x-breadcrumbs navigations="Pengaturan" active="Duplikasi Data"></x-breadcrumbs>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4>Ekspor Data PBB ke Tenant Lain</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="ms-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('duplikasi.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id" class="form-label">Id Tenant Tujuan</label>
                            <input type="number" class="form-control @error('id') is-invalid @enderror" placeholder="Kosongkan jika id belum diketahui"
                                   id="id" name="id" value="{{ old('id') }}" >
                            @error('id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Id tenant tujuan</div>
                        </div>
                        <div class="mb-3">
                            <label for="tenant_code" class="form-label">Kode Tenant Tujuan</label>
                            <input type="text" class="form-control @error('tenant_code') is-invalid @enderror" 
                                   id="tenant_code" name="tenant_code" value="{{ old('tenant_code') }}" required>
                            @error('tenant_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Kode tenant tujuan untuk data diduplikasi</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_start_range" class="form-label">ID Range Awal (Target)</label>
                            <input type="number" class="form-control @error('id_start_range') is-invalid @enderror" 
                                   id="id_start_range" name="id_start_range" value="{{ old('id_start_range', 1) }}" min="1" required>
                            @error('id_start_range')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">ID awal untuk penempatan data di tenant tujuan</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_end_range" class="form-label">ID Range Akhir (Target)</label>
                            <input type="number" class="form-control @error('id_end_range') is-invalid @enderror" 
                                   id="id_end_range" name="id_end_range" value="{{ old('id_end_range', 1000) }}" min="1" required>
                            @error('id_end_range')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">ID akhir untuk penempatan data di tenant tujuan</div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <strong>Perhatian:</strong> Proses duplikasi akan menyalin sejumlah data dari tenant saat ini 
                            ke tenant tujuan. Jumlah data yang disalin dihitung dari rentang ID yang ditentukan. 
                            Data pertama akan ditempatkan di ID sesuai dengan ID Range Awal yang ditentukan.
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Ekspor Data</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

</x-app-layout>