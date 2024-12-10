<x-admin-layout>
    <div class="p-6 bg-white shadow-md sm:rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Manage User Verification Requests</h2>
        <!-- Verification Requests Table -->
        <x-admin.verification-requests.verification-requests-table :verificationRequests="$verificationRequests" />
    </div>
</x-admin-layout>
