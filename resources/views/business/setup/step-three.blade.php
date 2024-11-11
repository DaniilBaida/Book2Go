<x-guest-layout>
    <form method="POST" action="{{ route('business.setup.storeStepThree') }}">
        @csrf
        <h2>Step 3: Choose Main Service Category</h2>

        <div>
            <label for="service_category" class="block text-sm font-medium text-gray-700">Categoria de Serviço</label>
            <select name="service_category" id="service_category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                <option value="">Selecione uma categoria</option>
                @foreach($services as $service)
                    <option value="{{ $service->name }}">{{ $service->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('service_category')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Finish Setup') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
