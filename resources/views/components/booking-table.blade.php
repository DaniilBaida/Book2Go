<div class="flex flex-col">
    @if($bookings->isEmpty())
        <p class="text-gray-600 mt-6">
            {{ $role === 'client' ? 'You have no bookings at the moment.' : 'No bookings available.' }}
        </p>
    @else
        <div class="flex-grow overflow-y-auto">
            <table class="w-full border-collapse table-auto">
                <thead>
                    <tr class="text-gray-500 uppercase text-xs leading-normal border-y h-6">
                        @if($role === 'business')
                            <!-- Checkbox Column for Business -->
                            <th class="p-3 text-left w-1/15">
                                <input
                                    type="checkbox"
                                    id="select-all"
                                    class="form-checkbox text-blue-600 rounded-md ring-0 ring-transparent"
                                >
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
                        <tr class="border-b border-gray-100 hover:bg-gray-100">
                            @if($role === 'business')
                                <!-- Checkbox Column for Business -->
                                <td class="p-3">
                                    <input
                                        type="checkbox"
                                        name="bookings[]"
                                        value="{{ $booking->id }}"
                                        class="form-checkbox h-4 w-4 text-blue-500 booking-checkbox rounded-md"
                                    >
                                </td>
                                <!-- User Column for Business -->
                                <td class="p-3 font-bold flex items-center gap-3">
                                    <!-- VIEW BOOKING -->
                                    <a href="{{ route($role . '.bookings.show', $booking) }}" class="flex items-center">
                                        <button class="bg-blue-400/20 hover:bg-blue-400/40 duration-300 rounded-full p-2 flex items-center justify-center">
                                            <i class="fa-solid fa-eye text-blue-800"></i>
                                        </button>
                                    </a>
                                    <span class="ml-2">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</span>
                                </td>
                            @endif
                            <!-- Shared Columns -->
                            <td class="p-3 font-bold">
                                @if($role === 'client')
                                <div class="flex gap-3">
                                    <!-- VIEW BOOKING -->
                                    <a href="{{ route($role . '.bookings.show', $booking) }}">
                                        <button class="bg-blue-400/20 hover:bg-blue-400/40 duration-300 rounded-full p-2 flex items-center justify-center">
                                            <i class="fa-solid fa-eye text-blue-800"></i>
                                        </button>
                                    </a>
                                    <span class="flex items-center">{{ $booking->service->name }}</span>
                                @endif
                                @if($role === 'business')
                                    <span class="flex items-center">{{ $booking->service->name }}</span>
                                @endif
                            </td>
                            <td class="p-3">{{ $booking->date->format('d M Y') }}</td>
                            <td class="p-3">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 text-[12px] font-normal rounded-full
                                    {{ $booking->status === 'accepted' ? 'bg-green-500/20 text-green-500' : ($booking->status === 'pending' ? 'bg-zinc-500/20 text-zinc-500' : 'bg-red-500/20 text-red-500') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="p-3 flex justify-start gap-2">
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
        </div>

        <!-- Pagination -->
        @if ($bookings->hasPages())
            <div class="mt-6">
                {{ $bookings->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    @endif
</div>
