<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Aplikasi Pencatatan Pajak Bumi dan Bangunan">
<meta name="viewport" content="width=device-width, initial-scale=1">

@livewireStyles(['nonce' => csp_nonce()])

<!-- Favicon -->
<link nonce="{{ csp_nonce() }}" rel="apple-touch-icon" href="{{ asset($favicon) }}">
<link nonce="{{ csp_nonce() }}" rel="shortcut icon" href="{{ asset($favicon) }}">

<!-- Style css -->
@vite('resources/sass/app.scss')
<link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{asset('/themes/assets/css/cs-skin-elastic.css')}}">
<link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{asset('/themes/assets/css/style.css')}}">
<meta name="robots" content="index, nofollow">
