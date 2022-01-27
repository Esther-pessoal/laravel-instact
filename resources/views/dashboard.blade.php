@extends('layouts.app')

@section('title', '| Dashboard')

@section('content')
    @include('components.navbar')
    </a>
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center" style="margin-top: 100px;">
        @include('components.post-card')
        @include('components.post-card')
        @include('components.post-card')
        @include('components.post-card')
    </div>
@endsection
