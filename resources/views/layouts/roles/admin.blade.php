@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.sidebar.admin-sidebar')
@endsection

@section('header')
    @include('layouts.partials.header.admin-header')
@endsection

@section('content')
    <main class="p-4">
        {{ $slot }}
    </main>
@endsection
