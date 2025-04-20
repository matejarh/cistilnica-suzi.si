@extends('layouts.email')

@section('title', 'Potrdite svoje povpraševanje')

@section('header-title', 'Potrdite svoje povpraševanje')

@section('content')
    <div style="overflow-wrap: break-word;">
        <p>Hvala, ker ste nam poslali povpraševanje! Za dokončanje postopka prosimo, da potrdite svoje povpraševanje s
            klikom na spodnji gumb.</p>

        <h3>Podrobnosti povpraševanja:</h3>
        <ul style="list-style: none; padding: 0; margin: 0; text-align: left;">

            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                <ul style="flex: 1; list-style: none; padding: 0; margin: 0; text-align: left;">
                    <li><strong>Ime:</strong> {{ $data['name'] }}</li>
                    <li><strong>Podjetje:</strong> {{ $data['company'] }}</li>
                    <li><strong>Email:</strong> {{ $data['email'] }}</li>
                </ul>
                <ul style="flex: 1; list-style: none; padding: 0; margin: 0;  text-align: left;">
                    <li><strong>Telefon:</strong> {{ $data['phone'] }}</li>
                    <li><strong>Naslov:</strong> {!! nl2br(e($data['address'])) !!}</li>
                </ul>
            </div>
            <li style="margin-top: 10px"><strong>Zadeva:</strong> {{ $data['subject'] }}</li>
            <li style="margin-top: 8px"><strong>Sporočilo:</strong><br>{!! $data['message'] !!}</li>
        </ul>

        <x-button-for-email :url="route('inquiries.store', ['token' => $token, 'email' => $email])">
            Potrdi povpraševanje
        </x-button-for-email>

        <p>Če povezava ne deluje, kopirajte in prilepite naslednji URL v svoj brskalnik:</p>
        <p style="line-height: 12pt; font-size: small;">
            <small>{!! route('inquiries.store', ['token' => $token, 'email' => $email]) !!}</small>
        </p>
    </div>
@endsection

@section('footer-text')
    <a href="{{ config('app.url') }}" style="text-decoration: none; color: inherit;">
        Čistilnica Suzi - vaša prva izbira za čistočo.
    </a>
@endsection
