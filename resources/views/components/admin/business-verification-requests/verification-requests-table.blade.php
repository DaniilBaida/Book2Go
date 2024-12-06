<div class="flex flex-col">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse table-auto">
            <thead>
                <tr class="text-gray-500 uppercase text-xs leading-normal border-y h-6">
                    <th class="p-3 text-left w-1/4">Name</th>
                    <th class="p-3 text-left w-1/4">Email</th>
                    <th class="p-3 text-left w-1/4">Status</th>
                    <th class="p-3 text-right w-[150px]">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
                @forelse ($verificationRequests as $request)
                    <tr class="border-b border-gray-100 hover:bg-gray-100 verification-row" data-status="{{ $request->verification_status }}">
                        <td class="p-3 font-bold">{{ $request->name }}</td>
                        <td class="p-3">{{ $request->email }}</td>
                        <td class="p-3 capitalize">{{ $request->verification_status }}</td>
                        <td class="p-3 flex justify-end gap-2">
                            @if ($request->verification_status === 'pending')
                                <form method="POST" action="{{ route('admin.business-verification-requests.approve', $request->id) }}">
                                    @csrf
                                    <button class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.business-verification-requests.reject', $request->id) }}">
                                    @csrf
                                    <button class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600">
                                        <i class="fa-solid fa-x"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-3">No verification requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $verificationRequests->links() }}
    </div>
</div>
