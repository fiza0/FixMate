<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Pending handymen -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pending Handyman Verifications</h3>
                    @if($pendingHandymen->isEmpty())
                        <p class="text-sm text-gray-600">No pending handymen.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-700">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2">Name</th>
                                        <th class="px-4 py-2">Skill</th>
                                        <th class="px-4 py-2">Location</th>
                                        <th class="px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingHandymen as $profile)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">{{ $profile->user->name }}</td>
                                            <td class="px-4 py-2">{{ ucfirst($profile->skill_category) }}</td>
                                            <td class="px-4 py-2">{{ $profile->location }}</td>
                                            <td class="px-4 py-2">
                                                <form method="POST" action="{{ route('admin.handymen.verify', $profile) }}">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded-md hover:bg-green-700"
                                                    >
                                                        Verify
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Users list -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Users</h3>
                        <a href="{{ route('admin.users.create') }}"
                           class="px-3 py-1 text-xs font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Add User
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-700">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Role</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $u)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $u->name }}</td>
                                        <td class="px-4 py-2">{{ $u->email }}</td>
                                        <td class="px-4 py-2 capitalize">{{ $u->role }}</td>
                                        <td class="px-4 py-2">
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                                @class([
                                                    'bg-green-100 text-green-800' => $u->active,
                                                    'bg-red-100 text-red-800' => ! $u->active,
                                                ])">
                                                {{ $u->active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 flex gap-2">
                                            @if(! $u->isAdmin())
                                                <form method="POST" action="{{ route('admin.users.toggle', $u) }}">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold text-white bg-yellow-600 rounded-md hover:bg-yellow-700"
                                                    >
                                                        {{ $u->active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        onclick="return confirm('Are you sure? This cannot be undone.');"
                                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded-md hover:bg-red-700"
                                                    >
                                                        Delete
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-500">Admin</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
