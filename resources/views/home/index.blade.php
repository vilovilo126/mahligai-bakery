@extends('layouts.landing')

@section('content')
    @include('home.partials.hero')
    @include('home.partials.marquee')
    @include('home.partials.about')
    @include('home.partials.products')
    @include('home.partials.gallery')
    @include('home.partials.location')
    @include('home.partials.testimonials')
    @include('home.partials.contact')
@endsection