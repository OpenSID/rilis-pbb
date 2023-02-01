@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))

@section('custom-message')
<p class="text-red-100">
    Mohon Periksa Log Error dan Laporkan Masalah di
    <a href="https://github.com/OpenSID/wiki-pbb/issues" target="_blank">Github</a>
    atau
    <a href="https://forum.opendesa.id/" target="_blank">Forum</a>
    dengan Melampirkan Log Error
</p>
@endsection
