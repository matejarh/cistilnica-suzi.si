@extends('layouts.email')

@section('title', 'Potrdi odjavo od akcij in promocij')

@section('header-title', 'Potrdite svojo odjavo')

@section('content')
<div style="overflow-wrap: break-word;">
    <p>Žal nam je, da se poslavljate! Za dokončanje odjave od naših akcij in promocij prosimo, da potrdite svojo odločitev s klikom na spodnji gumb.</p>
    <a href="{!! route('subscribers.unsubscribe.confirm', ['token' => $token, 'email' => $email]) !!}" class="button" style="display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff !important;
            background-color: #0ea5e9;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;">Potrdi odjavo</a>
    <p>Če povezava ne deluje, kopirajte in prilepite naslednji URL v svoj brskalnik:</p>
    <p style="line-height: 12pt; font-size: small;"><small>{!! route('subscribers.unsubscribe.confirm', ['token' => $token, 'email' => $email]) !!}</small></p>
</div>
@endsection

@section('footer-text', 'Čistilnica Suzi - vedno smo tu za vas, ko nas potrebujete.')
