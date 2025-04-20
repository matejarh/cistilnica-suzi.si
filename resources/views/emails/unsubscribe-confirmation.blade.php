@extends('layouts.email')

@section('title', 'Potrdi odjavo od akcij in promocij')

@section('header-title', 'Potrdite svojo odjavo')

@section('content')
    <div class="overflow-wrap: break-word;">

        <p>Žal nam je, da se poslavljate! Za dokončanje odjave od naših akcij in promocij prosimo, da potrdite svojo
            odločitev s klikom na spodnji gumb.</p>

        <x-button-for-email :url="$link">
            Potrdi odjavo
        </x-button-for-email>

        <p>Če povezava ne deluje, kopirajte in prilepite naslednji URL v svoj brskalnik:</p>
        <p style="line-height: 12pt; font-size: small; display:block"><small>{!! $link !!}</small></p>
    </div>


@endsection

@section('footer-text')
    <a href="{{ config('app.url') }}" target="_blank">Čistilnica Suzi - vedno smo tu za vas, ko nas potrebujete.</a>
@endsection
