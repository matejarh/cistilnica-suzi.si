@extends('layouts.email')

@section('title', 'Potrdi prijavo na akcije')

@section('header-title', 'Potrdite svojo prijavo na akcije')

@section('content')
    <div style="overflow-wrap: break-word;">
        <p>Hvala, ker ste se prijavili na naše novice! Za dokončanje prijave prosimo, da potrdite svoj e-poštni naslov s klikom na spodnji gumb.</p>
        <a href="{!! $link !!}" class="button" style="display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff !important;
            background-color: #0ea5e9;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;">Potrdi naročnino</a>
        <p>Če povezava ne deluje, kopirajte in prilepite naslednji URL v svoj brskalnik:</p>
        <p style="line-height: 12pt; font-size: small; "><small>{!! $link !!}</small></p>
    </div>
@endsection


@section('footer-text', 'Čistilnica Suzi - brezhibna čistoča za vaše perilo.')
