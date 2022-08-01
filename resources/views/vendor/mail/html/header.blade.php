<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Aplikasi PBB')
<img src="{{asset('/build/images/opendesa/logo/opendesa_logo.png')}}" width="auto" height="42px" class="logo" alt="Aplikasi PBB">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
