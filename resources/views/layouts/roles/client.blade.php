@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.sidebar.client-sidebar')
@endsection

@section('header')
    @include('layouts.partials.header.client-header')
@endsection

@section('content')
    <main class="p-4">
        {{ $slot }}
    </main>
@endsection
