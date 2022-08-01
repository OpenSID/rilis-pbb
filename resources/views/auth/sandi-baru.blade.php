<x-auth-layout title="Kata Sandi Baru">
    @section('form')
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <input type="email" name="email" id="email" class="form-control nav-input mt-4 mb-1" placeholder="Alamat email" required autofocus value="{{ old('email') ?? '' }}"/>

            <!-- Password -->
            <input type="password" name="password" id="password" class="form-control nav-input mt-4 mb-1" placeholder="Kata sandi baru" required/>

            <!-- Confirm Password -->
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control nav-input mt-4 mb-1" placeholder="Ulangi kata sandi" required/>

            @error('password')
                <div class="text-danger mt-1 d-block"><small>{{ $message }}</small></div>
            @enderror
            @error('password_confirmation')
                <div class="text-danger mt-1 d-block"><small>{{ $message }}</small></div>
            @enderror

            <!-- Button Submit -->
            <button type="submit" class="btn btn-success btn-flat mt-3 m-b-15" style="letter-spacing: 0.15em">SIMPAN</button>

        </form>
    @endsection
</x-auth-layout>
