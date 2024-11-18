<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Heading -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-5">
            <h1 class="text-3xl font-bold">Manage Your Discount Codes</h1>
            <a href="{{ route('business.discounts.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Create Discount Code
            </a>
        </div>

        <!-- Search and Table -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <!-- Success -->
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 bg-green-200 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Bar -->
            <form method="GET" action="{{ route('business.discounts.index') }}" class="flex items-center mb-4 space-x-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search discount codes"
                    class="border rounded-lg px-4 py-2 w-64 focus:ring-2 focus:ring-blue-500"
                />
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Search
                </button>
            </form>

            <!-- Table -->
            @include('business.discounts.partials.discount-table')
        </div>
    </div>
</x-business-layout>
