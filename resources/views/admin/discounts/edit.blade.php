<x-admin-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Heading -->
        <h1 class="text-3xl font-bold">Edit Discount Code</h1>

        <!-- Formulário -->
        <form method="POST" action="{{ route('admin.discounts.update', $discount->id) }}" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            @csrf
            @method('PUT')

            <!-- Code -->
            <div class="mb-4">
                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', $discount->code) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Type -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type" id="type" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="percentage" {{ $discount->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="fixed" {{ $discount->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                </select>
            </div>

            <!-- Value -->
            <div class="mb-4">
                <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
                <input type="number" name="value" id="value" value="{{ old('value', $discount->value) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Max Uses -->
            <div class="mb-4">
                <label for="max_uses" class="block text-sm font-medium text-gray-700">Max Uses</label>
                <input type="number" name="max_uses" id="max_uses" value="{{ old('max_uses', $discount->max_uses) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Expiry Date -->
            <div class="mb-4">
                <label for="expires_at" class="block text-sm font-medium text-gray-700">Expires At</label>
                <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at', $discount->expires_at ? \Carbon\Carbon::parse($discount->expires_at)->format('Y-m-d') : '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update Discount Code
            </button>
        </form>
    </div>
</x-admin-layout>
