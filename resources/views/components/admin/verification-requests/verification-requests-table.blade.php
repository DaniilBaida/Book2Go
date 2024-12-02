<div class="flex flex-col">
    <!-- Verification Requests Table -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse table-auto">
            <thead>
                <tr class="text-gray-500 uppercase text-xs leading-normal border-y h-6">
                    <th class="p-3 text-left w-1/4">
                        <a href="{{ route('admin.user-verification-requests.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Name
                            @if(request('sort') === 'name')
                                <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th class="p-3 text-left w-1/4">Email</th>
                    <th class="p-3 text-left w-1/4">Status</th>
                    <th class="p-3 text-right w-[150px]">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
                @forelse ($verificationRequests as $request)
                    <tr class="border-b border-gray-100 hover:bg-gray-100 verification-row" data-status="{{ $request->is_verified === 1 ? 'approved' : ($request->is_verified === 0 ? 'rejected' : 'pending')}}">
                        <td class="p-3 font-bold">{{ $request->first_name }} {{ $request->last_name }}</td>
                        <td class="p-3">{{ $request->email }}</td>
                        <td class="p-3">
                            @if($request->is_verified === 1)
                                Approved
                            @elseif($request->is_verified === 0)
                                Denied
                            @else
                                Pending
                            @endif
                        </td>
                        <td class="p-3 flex justify-end gap-2">
                            @if (!$request->is_verified)
                                <form method="POST" action="{{ route('admin.user-verification-requests.approve', $request->id) }}">
                                    @csrf
                                    <button class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.user-verification-requests.reject', $request->id) }}">
                                    @csrf
                                    <button class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600">
                                        <i class="fa-solid fa-x text-sm"></i>
                                    </button>
                                </form>
                            @else
                                <button class="bg-gray-400 text-white px-4 py-2 rounded shadow hover:bg-gray-500">View</button>
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

    <!-- Pagination -->
    <div class="mt-4">
        {{ $verificationRequests->links() }}
    </div>
</div>
