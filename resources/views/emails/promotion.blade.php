@extends('layouts.email')

@section('title')
    Nova promocija: {{ $promotion->name }}
@endsection

@section('header-title', 'Nova promocija')

@section('content')
    <p>Pozdravljeni, {{ $subscriber->name }}!</p>
    <p>Imamo novo promocijo za vas:</p>

    <h2>{{ $promotion->name }}</h2>
    <p>{!! $promotion->description !!}</p>

    @if ($promotion->image_url)
        <img src="{{ $promotion->image_url }}" alt="{{ $promotion->name }}" style="max-width: 100%; height: auto;">
    @endif

    <p>Promocija velja od {{ $promotion->formatted_start_date }} do {{ $promotion->formatted_end_date }}.</p>
    <p>Ne zamudite te priložnosti!</p>
@endsection

@section('footer-text', 'Čistilnica Suzi - brezhibna čistoča za vaše perilo.')

@section('footer')
    <p style="margin: 0;">Če želite prenehati prejemati naše e-pošte, se lahko <a href="{{ $unsubscribeUrl }}">odjavite tukaj</a>.</p>
    <p style="margin: 0;">Za več informacij o naših storitvah obiščite našo spletno stran: <a href="{{ route('public.home') }}">Čistilnica Suzi</a>.</p>
    <p style="margin: 0;">Vas zanima več? <a href="{{ route('public.akcije') }}">Oglejte si naše trenutne promocije</a>.</p>
@endsection
