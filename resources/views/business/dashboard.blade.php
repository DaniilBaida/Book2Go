<x-business-layout>
    <div class="px-4 py-8 max-w-8xl mx-auto">
        <div class="flex flex-col space-y-8 w-full">
            <!-- Dashboard actions -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <h1 class="text-3xl text-gray-800 font-bold">Dashboard</h1>
                <div class="mt-4 sm:mt-0 grid grid-flow-col gap-2 justify-start sm:justify-end">
                    <x-button class="flex items-center space-x-2">
                        <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                        </svg>
                        <span>Add View</span>
                    </x-button>
                </div>
            </div>

            <!-- Dashboard cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <x-dashboard.dashboard-card-01 title="Total Earnings" value="$98,457.20" percentage="3.47%" icon="users" :increase="true"/>
                <x-dashboard.dashboard-card-01 title="Customers" value="$2,982.54" percentage="9.69%" icon="users" :increase="true"/>
                <x-dashboard.dashboard-card-01 title="Orders" value="48,982.54" percentage="2.58%" icon="box" :increase="false"/>
                <x-dashboard.dashboard-card-01 title="Available Balance" value="$98,457.20" percentage="4.23%" icon="wallet" :increase="true"/>
            </div>

            <!-- Table -->
            <div class="w-full">
                <x-dashboard.dashboard-card-03 />
            </div>
        </div>
    </div>
</x-business-layout>
