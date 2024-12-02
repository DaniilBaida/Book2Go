<x-business-layout>
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Settings</h2>
    <div class="p-6 bg-white shadow-md sm:rounded-lg space-y-6">
        <!-- Notification Preferences -->
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Notification Preferences</h3>
            <div class="flex items-center mb-4">
                <input type="checkbox" id="email_notifications" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200">
                <label for="email_notifications" class="ml-2 text-sm text-gray-600">Email Notifications</label>
            </div>
            <div class="flex items-center mb-4">
                <input type="checkbox" id="sms_notifications" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200">
                <label for="sms_notifications" class="ml-2 text-sm text-gray-600">SMS Notifications</label>
            </div>
        </div>

        <!-- Privacy Settings -->
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Privacy Settings</h3>
            <div class="flex items-center mb-4">
                <input type="checkbox" id="profile_visibility" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200">
                <label for="profile_visibility" class="ml-2 text-sm text-gray-600">Make My Profile Public</label>
            </div>
        </div>

        <!-- Save Changes -->
        <div>
            <x-button class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200">
                Save Changes
            </x-button>
        </div>
    </div>
</x-business-layout>
