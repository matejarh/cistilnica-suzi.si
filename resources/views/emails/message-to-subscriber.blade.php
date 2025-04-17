@extends('layouts.email')

@section('title')
    Sporočilo
@endsection

@section('header-title', 'Sporočilo')

@section('content')
<p>Pozdravljeni, {{ $subscriber->email }}!</p>
<p>Imamo novo sporočilo za vas:</p>
<div style="color: #6c6b6b; font-size: 14px; margin-top: 10px; margin-bottom: 16px; padding: 10px; background-color: #f9f9f9; border-left: 4px solid #0ea5e9;">
    {!! is_string($custom_message) ? $custom_message : 'Ni sporočila za prikaz.' !!}
</div>


@endsection

@section('footer-text', 'Čistilnica Suzi - brezhibna čistoča za vaše perilo.')

@section('footer')
    <p style="margin: 0;">To sporočilo ste prejeli, ker ste naročeni na akcije. Če želite prenehati prejemati naše e-pošte, se lahko <a href="{{ $unsubscribeUrl }}">odjavite tukaj</a>.</p>
    <p style="margin: 0;">Za več informacij o naših storitvah obiščite našo spletno stran: <a href="{{ route('public.home') }}">Čistilnica Suzi</a>.</p>
    <p style="margin: 0;">Vas zanima več? <a href="{{ route('public.akcije') }}">Oglejte si naše trenutne promocije</a>.</p>
@endsection
