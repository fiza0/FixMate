<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Request Booking') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $handyman->name }}
                        </h3>
                        @if($handyman->handymanProfile)
                            <p class="text-sm text-gray-500">
                                {{ ucfirst($handyman->handymanProfile->skill_category) }}
                                • {{ $handyman->handymanProfile->location }}
                            </p>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('bookings.store') }}">
                        @csrf

                        <input type="hidden" name="handyman_id" value="{{ $handyman->id }}">

                        <div class="mb-4">
                            <x-input-label for="service_type" :value="__('Service type')" />
                            <x-text-input id="service_type" name="service_type" type="text"
                                          class="block w-full mt-1"
                                          :value="old('service_type')"
                                          required />
                            <x-input-error :messages="$errors->get('service_type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="scheduled_at" :value="__('Preferred date & time')" />
                            <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local"
                                          class="block w-full mt-1"
                                          :value="old('scheduled_at')"
                                          required />
                            <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="estimated_cost" :value="__('Estimated cost (optional)')" />
                            <x-text-input id="estimated_cost" name="estimated_cost" type="number" step="0.01" min="0"
                                          class="block w-full mt-1"
                                          :value="old('estimated_cost')" />
                            <x-input-error :messages="$errors->get('estimated_cost')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('handymen.index') }}"
                               class="px-4 py-2 text-sm text-gray-700 bg-white border rounded-md hover:bg-gray-50">
                                Cancel
                            </a>

                            <x-primary-button class="ms-3">
                                {{ __('Submit request') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
