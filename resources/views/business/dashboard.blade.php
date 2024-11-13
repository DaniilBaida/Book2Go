<x-business-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 max-sm:px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 gap-10 flex flex-col">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as a Business Owner!") }}
                </div>
            </div>

            <!-- Bar chart (Direct vs Indirect) -->
        
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-dashboard.dashboard-card-01 title="Total Earnings" value="$98,457.20" percentage="3.47%" icon="users" :increase="true"/>
                <x-dashboard.dashboard-card-01 title="Customers" value="$2,982.54" percentage="9.69%" icon="users" :increase="true"/>
                <x-dashboard.dashboard-card-01 title="Orders" value="48,982.54" percentage="2.58%" icon="box" :increase="false"/>
                <x-dashboard.dashboard-card-01 title="Available Balance" value="$98,457.20" percentage="4.23%" icon="wallet" :increase="true"/>
            </div>

            <div class="gap-10 flex flex-col">
                <x-dashboard.dashboard-card-03 />
                <x-dashboard.dashboard-card-02 :dataFeed="$dataFeed" />
            </div>
        </div>
    </div>
</x-business-layout>
