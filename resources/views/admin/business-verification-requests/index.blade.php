<x-admin-layout>
    <div class="p-6 bg-white shadow-md sm:rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Manage Business Verification Requests</h2>
        <!-- Search Component -->
        <x-admin.business-verification-requests.verification-requests-search />
        <!-- Table Component -->
        <x-admin.business-verification-requests.verification-requests-table :verificationRequests="$verificationRequests" />
    </div>
</x-admin-layout>
