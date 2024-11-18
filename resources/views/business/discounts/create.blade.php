@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-6">Create Discount Code</h1>
    <form method="POST" action="{{ route('business.discounts.store') }}" class="space-y-4 bg-white p-6 shadow-md rounded-lg">
    @csrf
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
            <input
                type="text"
                id="code"
                name="code"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required
            />
        </div>
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select
                id="type"
                name="type"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required
            >
                <option value="percentage">Percentage</option>
                <option value="fixed">Fixed Amount</option>
            </select>
        </div>
        <div>
            <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
            <input
                type="number"
                id="value"
                name="value"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required
            />
        </div>
        <div>
            <label for="max_uses" class="block text-sm font-medium text-gray-700">Max Uses</label>
            <input
                type="number"
                id="max_uses"
                name="max_uses"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
        </div>
        <div>
            <label for="expires_at" class="block text-sm font-medium text-gray-700">Expires At</label>
            <input
                type="date"
                id="expires_at"
                name="expires_at"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
        </div>

        <div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                Create
            </button>
        </div>
    </form>
</div>
@endsection
