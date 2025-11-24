<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Review Booking #') . $booking->id }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="mb-4 text-sm text-gray-600">
                        Handyman: <span class="font-semibold">{{ $booking->handyman->name }}</span>
                    </p>

                    <form method="POST" action="{{ route('reviews.store', $booking) }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="rating" :value="__('Rating (1–5)')" />
                            <select id="rating" name="rating"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <option value="">Select rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }}</option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="comment" :value="__('Comment (optional)')" />
                            <textarea
                                id="comment"
                                name="comment"
                                rows="4"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('comment') }}</textarea>
                            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('bookings.show', $booking) }}"
                               class="px-4 py-2 text-sm text-gray-700 bg-white border rounded-md hover:bg-gray-50">
                                Cancel
                            </a>

                            <x-primary-button class="ms-3">
                                {{ __('Submit review') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
