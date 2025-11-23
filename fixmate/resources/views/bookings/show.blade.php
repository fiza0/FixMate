<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Booking #') . $booking->id }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <div class="flex flex-col justify-between gap-4 md:flex-row">
                        <div>
                            <p class="text-sm text-gray-500">Service</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $booking->service_type }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p>
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                    @class([
                                        'bg-yellow-100 text-yellow-800' => $booking->status === 'requested',
                                        'bg-blue-100 text-blue-800' => $booking->status === 'accepted',
                                        'bg-indigo-100 text-indigo-800' => $booking->status === 'in_progress',
                                        'bg-green-100 text-green-800' => $booking->status === 'completed',
                                        'bg-red-100 text-red-800' => $booking->status === 'cancelled',
                                    ])">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <p class="text-sm text-gray-500">Homeowner</p>
                            <p class="text-gray-900">{{ $booking->homeowner->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Handyman</p>
                            <p class="text-gray-900">{{ $booking->handyman->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Scheduled at</p>
                            <p class="text-gray-900">
                                {{ $booking->scheduled_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Estimated cost</p>
                            <p class="text-gray-900">
                                @if($booking->estimated_cost)
                                    KSh {{ number_format($booking->estimated_cost, 2) }}
                                @else
                                    —
                                @endif
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="mt-1 text-gray-900">
                            {{ $booking->description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-wrap gap-3">
                    @if(session('success'))
                        <div class="w-full mb-3 text-sm text-green-700 bg-green-100 border border-green-200 rounded-md px-3 py-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="w-full mb-3 text-sm text-red-700 bg-red-100 border border-red-200 rounded-md px-3 py-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    @php
                        $user = auth()->user();
                    @endphp

                    {{-- Homeowner cancel --}}
                    @if($user->id === $booking->homeowner_id && in_array($booking->status, ['requested', 'accepted', 'in_progress']))
                        <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-red-700 bg-red-100 rounded-md hover:bg-red-200"
                            >
                                Cancel booking
                            </button>
                        </form>
                    @endif

                    {{-- Handyman actions --}}
                    @if($user->id === $booking->handyman_id)
                        @if($booking->status === 'requested')
                            <form method="POST" action="{{ route('bookings.accept', $booking) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700"
                                >
                                    Accept
                                </button>
                            </form>
                        @endif

                        @if($booking->status === 'accepted')
                            <form method="POST" action="{{ route('bookings.start', $booking) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700"
                                >
                                    Start job
                                </button>
                            </form>
                        @endif

                        @if($booking->status === 'in_progress')
                            <form method="POST" action="{{ route('bookings.complete', $booking) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-md hover:bg-green-700"
                                >
                                    Mark as completed
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Booking #') . $booking->id }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <div class="flex flex-col justify-between gap-4 md:flex-row">
                        <div>
                            <p class="text-sm text-gray-500">Service</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $booking->service_type }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p>
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                    @class([
                                        'bg-yellow-100 text-yellow-800' => $booking->status === 'requested',
                                        'bg-blue-100 text-blue-800' => $booking->status === 'accepted',
                                        'bg-indigo-100 text-indigo-800' => $booking->status === 'in_progress',
                                        'bg-green-100 text-green-800' => $booking->status === 'completed',
                                        'bg-red-100 text-red-800' => $booking->status === 'cancelled',
                                    ])">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <p class="text-sm text-gray-500">Homeowner</p>
                            <p class="text-gray-900">{{ $booking->homeowner->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Handyman</p>
                            <p class="text-gray-900">{{ $booking->handyman->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Scheduled at</p>
                            <p class="text-gray-900">
                                {{ $booking->scheduled_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Estimated cost</p>
                            <p class="text-gray-900">
                                @if($booking->estimated_cost)
                                    KSh {{ number_format($booking->estimated_cost, 2) }}
                                @else
                                    —
                                @endif
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="mt-1 text-gray-900">
                            {{ $booking->description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-wrap gap-3">
                    @if(session('success'))
                        <div class="w-full mb-3 text-sm text-green-700 bg-green-100 border border-green-200 rounded-md px-3 py-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="w-full mb-3 text-sm text-red-700 bg-red-100 border border-red-200 rounded-md px-3 py-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    @php
                        $user = auth()->user();
                    @endphp

                    {{-- Homeowner cancel --}}
                    @if($user->id === $booking->homeowner_id && in_array($booking->status, ['requested', 'accepted', 'in_progress']))
                        <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-red-700 bg-red-100 rounded-md hover:bg-red-200"
                            >
                                Cancel booking
                            </button>
                        </form>
                    @endif

                    {{-- Handyman actions --}}
                    @if($user->id === $booking->handyman_id)
                        @if($booking->status === 'requested')
                            <form method="POST" action="{{ route('bookings.accept', $booking) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700"
                                >
                                    Accept
                                </button>
                            </form>
                        @endif

                        @if($booking->status === 'accepted')
                            <form method="POST" action="{{ route('bookings.start', $booking) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700"
                                >
                                    Start job
                                </button>
                            </form>
                        @endif

                        @if($booking->status === 'in_progress')
                            <form method="POST" action="{{ route('bookings.complete', $booking) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-md hover:bg-green-700"
                                >
                                    Mark as completed
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
