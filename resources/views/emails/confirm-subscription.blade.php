@extends('layouts.email')

@section('title', 'Potrdi prijavo na akcije')

@section('header-title', 'Potrdite svojo prijavo na akcije')

@section('content')
    <p>Hvala, ker ste se prijavili na naše novice! Za dokončanje prijave prosimo, da potrdite svoj e-poštni naslov s klikom na spodnji gumb.</p>
    <a href="{{ route('subscribers.confirm', ['token' => $token, 'email' => $email]) }}" class="button">Potrdi naročnino</a>
    <p>Če povezava ne deluje, kopirajte in prilepite naslednji URL v svoj brskalnik:</p>
    <p style="line-height: 12pt; font-size: small;"><small>{{ route('subscribers.confirm', ['token' => $token, 'email' => $email]) }}</small></p>
@endsection

@section('footer-text', 'Čistilnica Suzi - brezhibna čistoča za vaše perilo.')
