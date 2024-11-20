<x-admin-layout>
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Review Details</h2>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Reviewer Information -->
            <div>
                <dt class="font-medium text-gray-600">Reviewer</dt>
                <dd class="text-gray-800">
                    @if($review->reviewer_type === 'client')
                        {{ $review->booking->user->first_name }} {{ $review->booking->user->last_name }}
                    @else
                        {{ $review->booking->service->business->name }}
                    @endif
                </dd>
            </div>

            <!-- Review Type -->
            <div>
                <dt class="font-medium text-gray-600">Review Type</dt>
                <dd class="text-gray-800">{{ ucfirst($review->type) }}</dd>
            </div>

            <!-- Reviewed Entity -->
            <div>
                <dt class="font-medium text-gray-600">Reviewed Entity</dt>
                <dd class="text-gray-800">
                    @if($review->type === 'service')
                        Service: {{ $review->booking->service->name }}
                    @else
                        Client: {{ $review->booking->user->first_name }} {{ $review->booking->user->last_name }}
                    @endif
                </dd>
            </div>

            <!-- Rating -->
            <div>
                <dt class="font-medium text-gray-600">Rating</dt>
                <dd class="text-gray-800">{{ $review->rating }} Stars</dd>
            </div>

            <!-- Status -->
            <div>
                <dt class="font-medium text-gray-600">Status</dt>
                <dd class="px-2 py-1 rounded text-white {{ $review->reported_at ? 'bg-red-500' : 'bg-green-500' }}">
                    {{ $review->reported_at ? 'Reported' : 'Approved' }}
                </dd>
            </div>

            <!-- Comment -->
            <div class="sm:col-span-2">
                <dt class="font-medium text-gray-600">Comment</dt>
                <dd class="text-gray-800">{{ $review->comment ?? 'No comment provided.' }}</dd>
            </div>

            <!-- Report Reason -->
            @if($review->reported_at)
                <div class="sm:col-span-2">
                    <dt class="font-medium text-gray-600">Report Reason</dt>
                    <dd class="text-gray-800">{{ $review->report_reason ?? 'No reason provided.' }}</dd>
                </div>
            @endif
        </dl>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('admin.reviews.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Reviews
            </a>
        </div>

        <!-- Approve/Reject Actions -->
        @if($review->reported_at)
            <div class="mt-6 flex space-x-4">
                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Approve Review
                    </button>
                </form>
                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Reject Review
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-admin-layout>
