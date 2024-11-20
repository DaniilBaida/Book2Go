<x-admin-layout>
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Manage Reviews</h2>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="mt-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mt-4 p-4 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if($reviews->isEmpty())
            <p class="text-gray-600">No reviews available for moderation.</p>
        @else
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="p-3 text-left">Reviewer</th>
                    <th class="p-3 text-left">Reviewed Entity</th>
                    <th class="p-3 text-left">Rating</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-light">
                @foreach($reviews as $review)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="p-3">
                            @if($review->reviewer_type === 'client')
                                {{ $review->booking->user->first_name }} {{ $review->booking->user->last_name }}
                            @else
                                {{ $review->booking->service->business->name }}
                            @endif
                        </td>
                        <td class="p-3">
                            @if($review->reviewer_type === 'client')
                                Business: {{ $review->booking->service->business->name }}
                            @else
                                Client: {{ $review->booking->user->first_name }} {{ $review->booking->user->last_name }}
                            @endif
                        </td>
                        <td class="p-3">{{ $review->rating }} Stars</td>
                        <td class="p-3">
                            @if($review->reported_at)
                                <span class="px-2 py-1 text-sm font-semibold rounded bg-red-500 text-white">
                                    Reported
                                </span>
                            @else
                                <span class="px-2 py-1 text-sm font-semibold rounded bg-green-500 text-white">
                                    Approved
                                </span>
                            @endif
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.reviews.show', $review) }}" class="text-blue-500 hover:underline">View</a>
                            @if($review->reported_at)
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-white bg-green-500 hover:bg-green-700 py-1 px-3 rounded">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-700 py-1 px-3 rounded">
                                        Reject
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-admin-layout>
