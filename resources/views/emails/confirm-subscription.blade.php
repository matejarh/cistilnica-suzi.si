@extends('layouts.email')

@section('title', 'Potrdi prijavo na akcije')

@section('header-title', 'Potrdite svojo prijavo na akcije')

@section('content')
    <div style="overflow-wrap: break-word;">
        <p>Hvala, ker ste se prijavili na naše novice! Za dokončanje prijave prosimo, da potrdite svoj e-poštni naslov s
            klikom na spodnji gumb.</p>

        <x-button-for-email :url="$link">
            Potrdi naročnino
        </x-button-for-email>

        <p>Če povezava ne deluje, kopirajte in prilepite naslednji URL v svoj brskalnik:</p>
        <p style="line-height: 12pt; font-size: small; "><small>{!! $link !!}</small></p>
    </div>
@endsection


@section('footer-text', 'Čistilnica Suzi - brezhibna čistoča za vaše perilo.')
