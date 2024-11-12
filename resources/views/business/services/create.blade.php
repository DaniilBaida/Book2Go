<x-business-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('business.services.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Service Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Service Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
                            @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="service_category_id" :value="__('Category')" />
                            <select id="service_category_id" name="service_category_id" class="block mt-1 w-full">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('service_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_category_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price (€)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ old('price') }}" required step="0.01" />
                            @error('price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Original Price -->
                        <div class="mb-4">
                            <x-input-label for="original_price" :value="__('Original Price (€)')" />
                            <x-text-input id="original_price" class="block mt-1 w-full" type="number" name="original_price" value="{{ old('original_price') }}" step="0.01" />
                            @error('original_price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Discount Price -->
                        <div class="mb-4">
                            <x-input-label for="discount_price" :value="__('Discount Price (€)')" />
                            <x-text-input id="discount_price" class="block mt-1 w-full" type="number" name="discount_price" value="{{ old('discount_price') }}" step="0.01" />
                            @error('discount_price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Discount Start Date -->
                        <div class="mb-4">
                            <x-input-label for="discount_start_date" :value="__('Discount Start Date')" />
                            <x-text-input id="discount_start_date" class="block mt-1 w-full" type="datetime-local" name="discount_start_date" value="{{ old('discount_start_date') }}" />
                            @error('discount_start_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Discount End Date -->
                        <div class="mb-4">
                            <x-input-label for="discount_end_date" :value="__('Discount End Date')" />
                            <x-text-input id="discount_end_date" class="block mt-1 w-full" type="datetime-local" name="discount_end_date" value="{{ old('discount_end_date') }}" />
                            @error('discount_end_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div class="mb-4">
                            <x-input-label for="duration_minutes" :value="__('Duration (minutes)')" />
                            <x-text-input id="duration_minutes" class="block mt-1 w-full" type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" required />
                            @error('duration_minutes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Service Image')" />
                            <input id="image" type="file" name="image" class="block mt-1 w-full" accept="image/*" />
                            @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full">
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>{{ __('Archived') }}</option>
                            </select>
                            @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="mb-4">
                            <x-input-label for="tags" :value="__('Tags')" />
                            <x-text-input id="tags" class="block mt-1 w-full" type="text" name="tags" value="{{ old('tags') }}" placeholder="e.g., haircut, grooming, spa" />
                            <small class="text-gray-500">{{ __('Comma-separated values') }}</small>
                            @error('tags')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Add-Ons -->
                        <div class="mb-4">
                            <x-input-label for="add_ons" :value="__('Add-Ons')" />
                            <textarea id="add_ons" name="add_ons" class="block mt-1 w-full" rows="2">{{ old('add_ons') }}</textarea>
                            <small class="text-gray-500">{{ __('Enter JSON-formatted data for additional options') }}</small>
                            @error('add_ons')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ml-4">
                                {{ __('Create Service') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-business-layout>
