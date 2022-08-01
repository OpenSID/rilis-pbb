<x-auth-layout title="Lupa Kata Sandi">
    @section('form')
        <form method="post" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control mb-3" placeholder="Email" required data-validate-linked='email'>
            </div>

            @if (session('status'))
                <div class="alert alert-success text-center mt-2">
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <button type="submit" class="btn btn-success btn-flat m-b-15" style="letter-spacing: 0.15em">Kirim</button>
        </form>
    @endsection
</x-auth-layout>
