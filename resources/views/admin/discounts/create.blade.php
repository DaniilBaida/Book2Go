<x-admin-layout>
    <div class="p-6 bg-white shadow sm:rounded-lg">
        <h1 class="text-2xl font-bold mb-6">Create Discount Code</h1>

        <!-- Sucesso -->
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 bg-green-200 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulário de Criação -->
        <form method="POST" action="{{ route('admin.discounts.store') }}">
            @csrf
            <div class="mb-4">
                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                <input
                    type="text"
                    id="code"
                    name="code"
                    value="{{ old('code') }}"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    required
                />
                @error('code')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select
                    id="type"
                    name="type"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    required
                >
                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                </select>
                @error('type')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
                <input
                    type="number"
                    id="value"
                    name="value"
                    value="{{ old('value') }}"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    required
                />
                @error('value')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="max_uses" class="block text-sm font-medium text-gray-700">Max Uses (optional)</label>
                <input
                    type="number"
                    id="max_uses"
                    name="max_uses"
                    value="{{ old('max_uses') }}"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                />
                @error('max_uses')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="expires_at" class="block text-sm font-medium text-gray-700">Expires At (optional)</label>
                <input
                    type="date"
                    id="expires_at"
                    name="expires_at"
                    value="{{ old('expires_at') }}"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                />
                @error('expires_at')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botões -->
            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.discounts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" class="ml-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Create Discount
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
