<x-auth-layout title="Login">
    @section('form')
        <!-- Form -->
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group">
                <label>Nama Pengguna / Email</label>
                <input type="text" value="{{ old('username') }}" name="username" id="username" class="form-control" placeholder="Nama Pengguna / Email" required="required" data-validate-linked='email'/>
            </div>

            <div class="form-group py-3">
                <label>Kata Sandi</label>
                <input type="password" value="{{ old('password') }}" name="password" id="password" class="form-control" placeholder="Kata Sandi" required="">
            </div>

            <div class="">
                @error('message')
                    <div class="text-danger mt-2">
                        {{ $message }}
                    </div>
                    <br/>
                @enderror
            </div>

            <div class="checkbox">
                <input type="checkbox" id="checkbox" class="form-checkbox"> Tampilkan kata sandi
                <label class="pull-right">
                    <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                </label>
            </div>

            <button type="submit" class="btn btn-success btn-flat m-b-3 m-t-30 mt-2 ls-15">Masuk</button>
        </form>
    @endsection

    <!-- Scripts -->
    @include('layouts.includes.scripts')

    <script nonce="{{ csp_nonce() }}">
    document.addEventListener("DOMContentLoaded", () => {
        var pass = $("#password");
        $('#checkbox').click(function() {
            if (pass.attr('type') === "password") {
                pass.attr('type', 'text');
            } else {
                pass.attr('type', 'password')
            }
        });
    });
    </script>
</x-auth-layout>
