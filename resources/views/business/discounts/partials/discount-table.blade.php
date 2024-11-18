<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3">Code</th>
                <th class="px-6 py-3">Type</th>
                <th class="px-6 py-3">Value</th>
                <th class="px-6 py-3">Max Uses</th>
                <th class="px-6 py-3">Current Uses</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Expires At</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($discountCodes as $code)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $code->code }}</td>
                    <td class="px-6 py-4">{{ ucfirst($code->type) }}</td>
                    <td class="px-6 py-4">{{ $code->value }}</td>
                    <td class="px-6 py-4">{{ $code->max_uses ?? 'Unlimited' }}</td>
                    <td class="px-6 py-4">{{ $code->uses }}</td>
                    <td class="px-6 py-4">{{ ucfirst($code->status) }}</td>
                    <td class="px-6 py-4">
                        {{ $code->expires_at ? \Carbon\Carbon::parse($code->expires_at)->format('Y-m-d') : 'No Expiry' }}
                    </td>
                    <td class="px-6 py-4 flex space-x-2">
                        <a href="{{ route('business.discounts.edit', $code->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('business.discounts.destroy', $code->id) }}" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $discountCodes->appends(['search' => request('search')])->links('vendor.pagination.tailwind') }}
</div>
