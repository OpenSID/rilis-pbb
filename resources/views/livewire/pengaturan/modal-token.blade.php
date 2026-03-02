<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
            <h5 class="modal-title" id="tokenModalLabel">Dapatkan Token OpenSID</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @if (session()->has('message-success'))
            <div class="text-center alert alert-success">
                {{ session('message-success') }}
            </div>
            @elseif(session()->has('message-failed'))
            <div class="text-center alert alert-danger">
                {{ session('message-failed') }}
            </div>
            @endif
            
            <div class="mb-3 row">
                <label for="tokenUrl" class="col-sm-3 col-form-label">URL API OpenSID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('tokenUrl') is-invalid @enderror"
                           id="tokenUrl" wire:model.live="tokenUrl" placeholder="https://opensid.example.com">
                    @error('tokenUrl')
                    <div class="invalid-feedback text-start">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tokenEmail" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('tokenEmail') is-invalid @enderror"
                           id="tokenEmail" wire:model.live="tokenEmail" placeholder="Email">
                    @error('tokenEmail')
                    <div class="invalid-feedback text-start">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tokenPassword" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control @error('tokenPassword') is-invalid @enderror"
                           id="tokenPassword" wire:model.live="tokenPassword" placeholder="Password">
                    @error('tokenPassword')
                    <div class="invalid-feedback text-start">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" wire:click="authenticateAndRetrieveToken">
                <i class="fa fa-key"></i> Dapatkan Token
            </button>
        </div>
    </div>
</div>