<x-client-layout>
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <h1 class="text-3xl text-gray-800 font-bold">Client Dashboard</h1>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                <p>You have {{ auth()->user()->unreadNotifications->count() }} new notification(s).</p>
            </div>
        @endif
    </div>
</x-client-layout>
