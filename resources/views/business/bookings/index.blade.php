<x-business-layout>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-800">Manage Bookings</h2>

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

        <!-- Bulk Action Buttons -->
        <div class="flex justify-between items-center mt-6">
            <div>
                <button type="button" id="bulk-accept" disabled class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                    Accept Selected
                </button>
                <button type="button" id="bulk-deny" disabled class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                    Deny Selected
                </button>
            </div>
        </div>

        <!-- Bookings Table -->
        @if($bookings->isEmpty())
            <p class="mt-6 text-gray-500">No bookings available.</p>
        @else
            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left">
                            <input type="checkbox" id="select-all" class="form-checkbox h-4 w-4 text-blue-600">
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-6">
                                <input type="checkbox" name="bookings[]" value="{{ $booking->id }}" class="form-checkbox h-4 w-4 text-blue-600 booking-checkbox">
                            </td>
                            <td class="py-3 px-6">{{ $booking->service->name }}</td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                            <td class="py-3 px-6">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($booking->status == 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-6 space-x-2">
                                <a href="{{ route('business.bookings.show', $booking) }}" class="text-blue-500 hover:text-blue-700">Show</a>
                                <form action="{{ route('business.bookings.accept', $booking) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-white bg-green-500 hover:bg-green-700 py-1 px-3 rounded">Accept</button>
                                </form>
                                <form action="{{ route('business.bookings.deny', $booking) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-700 py-1 px-3 rounded">Deny</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const bookingCheckboxes = document.querySelectorAll('.booking-checkbox');
            const bulkAccept = document.getElementById('bulk-accept');
            const bulkDeny = document.getElementById('bulk-deny');

            selectAllCheckbox.addEventListener('change', function () {
                bookingCheckboxes.forEach(checkbox => checkbox.checked = this.checked);
                toggleBulkActionButtons();
            });

            bookingCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleBulkActionButtons);
            });

            bulkAccept.addEventListener('click', function () {
                performBulkAction('accept');
            });

            bulkDeny.addEventListener('click', function () {
                performBulkAction('deny');
            });

            function toggleBulkActionButtons() {
                const anyChecked = Array.from(bookingCheckboxes).some(checkbox => checkbox.checked);
                bulkAccept.disabled = bulkDeny.disabled = !anyChecked;
                bulkAccept.classList.toggle('opacity-50', !anyChecked);
                bulkDeny.classList.toggle('opacity-50', !anyChecked);
                bulkAccept.classList.toggle('cursor-not-allowed', !anyChecked);
                bulkDeny.classList.toggle('cursor-not-allowed', !anyChecked);
            }

            function performBulkAction(action) {
                const selectedBookings = Array.from(bookingCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedBookings.length === 0) {
                    alert('Please select at least one booking.');
                    return;
                }

                if (!confirm(`Are you sure you want to ${action} the selected bookings?`)) {
                    return;
                }

                fetch('{{ route('business.bookings.bulk') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        bookings: selectedBookings,
                        action: action
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            }
        });
    </script>
</x-business-layout>
