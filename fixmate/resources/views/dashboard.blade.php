<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php $user = auth()->user(); @endphp

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">
                        Welcome back, {{ $user->name }}.
                    </p>

                    @if($user->isHomeowner())
                        <p class="mb-4 text-sm text-gray-600">
                            You are logged in as a <span class="font-semibold">Homeowner</span>.
                        </p>

                        <div class="grid gap-4 md:grid-cols-3">
                            <a href="{{ route('handymen.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h3 class="font-semibold text-gray-900 mb-1">Find a handyman</h3>
                                <p class="text-sm text-gray-600">
                                    Search by skill, location and rating.
                                </p>
                            </a>

                            <a href="{{ route('bookings.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h3 class="font-semibold text-gray-900 mb-1">My bookings</h3>
                                <p class="text-sm text-gray-600">
                                    View and manage your service requests.
                                </p>
                            </a>

                            <a href="{{ route('profile.edit') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h3 class="font-semibold text-gray-900 mb-1">Profile</h3>
                                <p class="text-sm text-gray-600">
                                    Update your details and contact information.
                                </p>
                            </a>
                        </div>
                    @elseif($user->isHandyman())
                        <p class="mb-4 text-sm text-gray-600">
                            You are logged in as a <span class="font-semibold">Handyman</span>.
                        </p>

                        <div class="grid gap-4 md:grid-cols-3">
                            <a href="{{ route('bookings.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h3 class="font-semibold text-gray-900 mb-1">Assigned bookings</h3>
                                <p class="text-sm text-gray-600">
                                    See upcoming jobs and update their status.
                                </p>
                            </a>

                            <a href="{{ route('profile.edit') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h3 class="font-semibold text-gray-900 mb-1">My profile</h3>
                                <p class="text-sm text-gray-600">
                                    Keep your contact info and skills up to date.
                                </p>
                            </a>
                        </div>
                    @elseif($user->isAdmin())
                        <p class="mb-4 text-sm text-gray-600">
                            You are logged in as an <span class="font-semibold">Admin</span>.
                        </p>

                        <div class="grid gap-4 md:grid-cols-3">
                            <a href="{{ route('bookings.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h3 class="font-semibold text-gray-900 mb-1">All bookings</h3>
                                <p class="text-sm text-gray-600">
                                    Inspect and monitor current jobs.
                                </p>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
