<x-admin-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Heading -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-5">
            <h1 class="text-3xl font-bold">Manage Discount Codes</h1>
            <!-- Botão para criar novo código -->
            <a href="{{ route('admin.discounts.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Create Discount Code
            </a>
        </div>

        <!-- Caixa de Pesquisa -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <!-- Mensagem de Sucesso -->
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 bg-green-200 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Barra de Pesquisa -->
            <form method="GET" action="{{ route('admin.discounts.index') }}" class="flex items-center mb-4 space-x-2">
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

            <!-- Inclusão da Tabela -->
            @include('admin.discounts.partials.discount-table', ['discountCodes' => $discountCodes])

            <!-- Paginação -->
            <div class="mt-6">
                {{ $discountCodes->appends(['search' => request('search')])->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-admin-layout>
