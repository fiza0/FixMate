<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ auth()->user()->isHandyman() ? 'My Jobs' : 'My Bookings' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">Ref</th>
                            <th class="px-6 py-3">Handyman / Homeowner</th>
                            <th class="px-6 py-3">Service</th>
                            <th class="px-6 py-3">Scheduled</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr class="border-t">
                                <td class="px-6 py-4 text-gray-900">
                                    #{{ $booking->id }}
                                </td>
                                <td class="px-6 py-4">
                                    @if(auth()->user()->isHandyman())
                                        {{ $booking->homeowner->name }}
                                    @else
                                        {{ $booking->handyman->name }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $booking->service_type }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $booking->scheduled_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
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
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a
                                        href="{{ route('bookings.show', $booking) }}"
                                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-900"
                                    >
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                    No bookings yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
