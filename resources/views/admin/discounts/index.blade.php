@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Discount Codes</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Expires At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discountCodes as $code)
                <tr>
                    <td>{{ $code->code }}</td>
                    <td>{{ ucfirst($code->type) }}</td>
                    <td>{{ $code->value }}</td>
                    <td>{{ $code->expires_at ? $code->expires_at->format('Y-m-d') : 'No Expiry' }}</td>
                    <td>
                        <a href="{{ route('admin.discounts.edit', $code->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.discounts.destroy', $code->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
