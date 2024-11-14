<x-business-layout>
    <div class="p-4 gap-5 flex flex-col">
        <!-- Dashboard actions -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h1 class="text-3xl text-gray-800 font-bold">Dashboard</h1>
            <div class="mt-4 sm:mt-0 grid grid-flow-col gap-2 justify-start sm:justify-end">
                <x-button class="flex items-center space-x-2">
                    <span>+ Add View</span>
                </x-button>
            </div>
        </div>
        
        <!-- Dashboard cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <x-dashboard.dashboard-card title="Total Earnings" value="$98,457.20" percentage="3.47%" icon="users" :increase="true"/>
            <x-dashboard.dashboard-card title="Customers" value="$2,982.54" percentage="9.69%" icon="users" :increase="true"/>
            <x-dashboard.dashboard-card title="Orders" value="48,982.54" percentage="2.58%" icon="box" :increase="false"/>
            <x-dashboard.dashboard-card title="Available Balance" value="$98,457.20" percentage="4.23%" icon="wallet" :increase="true"/>
        </div>
    </div>
</x-business-layout>