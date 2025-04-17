@extends('layouts.email')

@section('title', 'Odgovor na povpraševanje')

@section('header-title', 'Odgovor na povpraševanje')

@section('content')
    <div style="overflow-wrap: break-word;">
        <p style="margin-bottom: 16px;">Pozdravljeni,</p>
        <p style="margin-bottom: 16px;">Prejeli ste odgovor na vaše povpraševanje. Spodaj so podrobnosti:</p>

        <h3 style="margin-bottom: 16px;">Podrobnosti povpraševanja:</h3>
        <ul style="list-style: none; padding: 0; margin: 0; text-align: left; margin-top: 10px; margin-bottom: 16px; padding: 10px; background-color: #f9f9f9; border-left: 4px solid #0ea5e9;">
            <li style="margin-bottom: 10px;"><strong>Zadeva:</strong> {{ $inquiry['subject'] }}</li>
            <li style="margin-bottom: 10px;"><strong>Sporočilo:</strong><br>{{ $inquiry['message'] }}</li>
        </ul>

        <p style="margin-top: 20px; margin-bottom: 16px;">Na vaše povpraševanje smo odgovorili z naslednjim sporočilom:</p>
        <div style="margin-top: 10px; margin-bottom: 16px; padding: 10px; background-color: #f9f9f9; border-left: 4px solid #0ea5e9;">
            {!! $reply['reply'] !!}
        </div>

        <p style="margin-top: 20px; margin-bottom: 16px; font-size: small;">Za dodatna vprašanja ali informacije nas lahko kontaktirate na
            <a href="mailto:{{ $reply['email'] }}" style="color: #0ea5e9; text-decoration: none;">{{ $reply['email'] }}</a>.
        </p>

        <p style="margin-top: 20px; margin-bottom: 16px;">Hvala, ker ste izbrali našo čistilnico!</p>

        <p style="margin-top: 20px; margin-bottom: 16px;">Lep pozdrav,<br>Ekipa Čistilnice Suzi</p>

        <p style="margin-top: 20px; font-style: italic; color: #7a7b7c;">P.S. Ne pozabite, da smo tukaj, da vam pomagamo z vsemi vašimi potrebami po čiščenju!</p>




    </div>
@endsection
@section('footer-text', 'Čistilnica Suzi - vaša prva izbira za čistočo.')
