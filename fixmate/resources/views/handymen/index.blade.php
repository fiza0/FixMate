<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Find a Handyman') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Search form -->
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('handymen.index') }}" class="grid gap-4 md:grid-cols-4">
                        <div>
    <label for="skill" class="block text-sm font-medium text-gray-700">Skill</label>
    <select
        id="skill"
        name="skill"
        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >
        <option value="">Any skill</option>
        @foreach(['plumber', 'electrician', 'carpenter', 'mechanic', 'painter', 'general'] as $cat)
            <option value="{{ $cat }}" {{ request('skill') == $cat ? 'selected' : '' }}>
                {{ ucfirst($cat) }}
            </option>
        @endforeach
    </select>
</div>


                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input
                                id="location"
                                name="location"
                                type="text"
                                value="{{ request('location') }}"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="City / estate"
                            >
                        </div>

                        <div>
                            <label for="min_rating" class="block text-sm font-medium text-gray-700">Min rating</label>
                            <input
                                id="min_rating"
                                name="min_rating"
                                type="number"
                                min="1"
                                max="5"
                                step="0.5"
                                value="{{ request('min_rating') }}"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <div class="flex items-end">
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($handymen as $profile)
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $profile->user->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        {{ ucfirst($profile->skill_category) }} • {{ $profile->location }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Rating</p>
                                    <p class="text-lg font-semibold text-yellow-500">
                                        {{ number_format($profile->average_rating, 1) }}/5
                                    </p>
                                </div>
                            </div>

                            @if ($profile->bio)
                                <p class="mt-3 text-sm text-gray-700 line-clamp-3">
                                    {{ $profile->bio }}
                                </p>
                            @endif

                            <p class="mt-3 text-sm text-gray-600">
                                From <span class="font-semibold">KSh {{ number_format($profile->min_rate, 2) }}</span>
                                @if($profile->max_rate)
                                    to <span class="font-semibold">KSh {{ number_format($profile->max_rate, 2) }}</span>
                                @endif
                            </p>

                            @auth
                                @if(auth()->user()->isHomeowner())
                                    <div class="mt-4">
                                        <a
                                            href="{{ route('bookings.create', $profile->user) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        >
                                            Request Booking
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="p-6 text-center bg-white shadow-sm sm:rounded-lg">
                            <p class="text-gray-600">No handymen found matching your filters.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $handymen->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
