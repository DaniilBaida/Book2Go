<x-business-layout>
    <x-business.services.service-form
        :action="route('business.services.update', $service)"
        :method="'PUT'"
        :title="'Edit Service'"
        :buttonText="'Update Service'"
        :categories="$categories"
        :service="$service"
    />
</x-business-layout>
