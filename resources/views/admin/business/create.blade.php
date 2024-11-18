@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New Business</h1>
    <form action="{{ route('admin.businesses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.business.partials.edit-business-information-form', ['business' => null])
        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
</div>
@endsection