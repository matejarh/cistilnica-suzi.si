@extends('layouts.email')

@section('title', 'Potrdi odjavo od akcij in promocij')

@section('header-title', 'Potrdite svojo odjavo')

@section('content')
    <p>Žal nam je, da se poslavljate! Za dokončanje odjave od naših akcij in promocij prosimo, da potrdite svojo odločitev s klikom na spodnji gumb.</p>
    <a href="{{ route('subscribers.unsubscribe.confirm', ['token' => $token, 'email' => $email]) }}" class="button">Potrdi odjavo</a>
    <p>Če povezava ne deluje, kopirajte in prilepite naslednji URL v svoj brskalnik:</p>
    <p style="line-height: 12pt; font-size: small;"><small>{{ route('subscribers.unsubscribe.confirm', ['token' => $token, 'email' => $email]) }}</small></p>
@endsection

@section('footer-text', 'Čistilnica Suzi - vedno smo tu za vas, ko nas potrebujete.')
