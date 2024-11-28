<x-business-layout>
    <x-business.services.service-form
        :action="route('business.services.store')"
        :method="'POST'"
        :title="'Create Service'"
        :buttonText="'Create Service'"
        :categories="$categories"
        :service="null"
    />
</x-business-layout>
