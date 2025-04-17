@extends('layouts.email')

@section('title', 'Novo povpraševanje')

@section('header-title', 'Novo povpraševanje')

@section('content')
    <div style="overflow-wrap: break-word;">
        <p>Pozdravljeni,</p>
        <p>Prejeli ste novo povpraševanje. Spodaj so podrobnosti:</p>

        <h3>Podrobnosti povpraševanja:</h3>
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            <ul style="flex: 1; list-style: none; padding: 0; margin: 0; text-align: left; min-width: 200px;">
                <li><strong>Ime:</strong> {{ $inquiry['name'] }}</li>
                <li><strong>Podjetje:</strong> {{ $inquiry['company'] }}</li>
                <li><strong>Email:</strong> {{ $inquiry['email'] }}</li>
            </ul>
            <ul style="flex: 1; list-style: none; padding: 0; margin: 0; text-align: left; min-width: 200px;">
                <li><strong>Telefon:</strong> {{ $inquiry['phone'] }}</li>
                <li><strong>Naslov:</strong> {{ $inquiry['address'] }}</li>
            </ul>
        </div>
        <ul style="list-style: none; padding: 0; margin: 0; text-align: left;">
            <li style="margin-top: 10px"><strong>Zadeva:</strong> {{ $inquiry['subject'] }}</li>
            <li style="margin-top: 8px"><strong>Sporočilo:</strong><br>{{ $inquiry['message'] }}</li>
        </ul>

        <x-button-for-email :url="route('inquiries.show', ['inquiry' => $inquiry])">
            Odgovori na povpraševanje
        </x-button-for-email>

        <p>Če povezava ne deluje, kopirajte in prilepite naslednji URL v svoj brskalnik:</p>
        <p style="line-height: 12pt; font-size: small;">
            <small>{!! route('inquiries.show', ['inquiry' => $inquiry]) !!}</small>
        </p>
    </div>
@endsection

@section('footer-text', 'Čistilnica Suzi - vaša prva izbira za čistočo.')
