@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('images/logoSuzi150.png') }}" class="logo" alt="Čistilnica Suzi Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
