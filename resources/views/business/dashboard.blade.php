<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Dashboard actions -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h1 class="text-3xl text-gray-800 font-bold">Business Dashboard</h1>
            <div class="mt-4 sm:mt-0 grid grid-flow-col gap-2 justify-start sm:justify-end">
                <x-button class="flex items-center space-x-2">
                    <span>+ Add View</span>
                </x-button>
            </div>
        </div>

        <!-- Dashboard cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            <!-- Total Bookings Card -->
            <x-dashboard.dashboard-card
                title="Bookings This Month"
                :value="$currentMonthBookings"
                :percentage="$percentageChangeInBookings . '%'"
                icon="users"
                :increase="$percentageChangeInBookings > 0"
            />
            <!-- Total Services Card -->
            <x-dashboard.dashboard-card
                title="Services This Month"
                :value="$totalServices"
                :percentage="$percentageChangeInServices . '%'"
                icon="box"
                :increase="$percentageChangeInServices > 0"
            />

            <!-- Profile Completion Card -->
            <x-dashboard.dashboard-card
                title="Profile Completion"
                :value="$profileCompletion . '%'"
                icon="clipboard"
                :increase="true"
            />


        </div>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                <p>You have {{ auth()->user()->unreadNotifications->count() }} new notification(s).</p>
            </div>
        @endif
    </div>
</x-business-layout>
