<div>
    @if($bookings->isEmpty())
        <p class="text-gray-600 mt-6">
            {{ $role === 'client' ? 'You have no bookings at the moment.' : 'No bookings available.' }}
        </p>
    @else
        <table class="w-full border-collapse table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    @if($role === 'business')
                        <!-- Checkbox Column for Business -->
                        <th class="p-3 text-left w-1/12">
                            <input type="checkbox" id="select-all" class="form-checkbox h-4 w-4 text-blue-600">
                        </th>
                        <!-- User Column for Business -->
                        <th class="p-3 text-left w-1/5">
                            <a href="{{ route('business.bookings', ['sort' => 'user', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                User
                                @if(request('sort') === 'user')
                                    <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                    @endif
                    <!-- Shared Columns -->
                    <th class="p-3 text-left w-1/5">
                        <a href="{{ route($role . '.bookings', ['sort' => 'service', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Service
                            @if(request('sort') === 'service')
                                <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th class="p-3 text-left w-1/7">
                        <a href="{{ route($role . '.bookings', ['sort' => 'date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Date
                            @if(request('sort') === 'date')
                                <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th class="p-3 text-left w-1/7">
                        <a href="{{ route($role . '.bookings', ['sort' => 'start_time', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Time
                            @if(request('sort') === 'start_time')
                                <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th class="p-3 text-left w-1/7">
                        <a href="{{ route($role . '.bookings', ['sort' => 'status', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Status
                            @if(request('sort') === 'status')
                                <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th class="p-3 text-left w-1/5">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
                @foreach($bookings as $booking)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        @if($role === 'business')
                            <!-- Checkbox Column for Business -->
                            <td class="p-3">
                                <input type="checkbox" name="bookings[]" value="{{ $booking->id }}" class="form-checkbox h-4 w-4 text-blue-600 booking-checkbox">
                            </td>
                            <!-- User Column for Business -->
                            <td class="p-3 font-bold">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</td>
                        @endif
                        <!-- Shared Columns -->
                        <td class="p-3 font-bold">{{ $booking->service->name }}</td>
                        <td class="p-3">{{ $booking->date->format('d M Y') }}</td>
                        <td class="p-3">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-sm font-semibold rounded-full
                                {{ $booking->status === 'accepted' ? 'bg-green-500 text-white' : ($booking->status === 'pending' ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="p-3 flex justify-start gap-2">
                            <!-- VIEW BOOKING -->
                            <a href="{{ route($role . '.bookings.show', $booking) }}" class="text-blue-500">
                                <x-button-secondary>View</x-button-secondary>
                            </a>
                            <!-- CLIENT -->
                            @if($role === 'client')
                                @include('client.bookings.partials.client-booking-actions', ['booking' => $booking])
                            @elseif($role === 'business')
                                @include('business.bookings.partials.business-booking-actions', ['booking' => $booking])
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
