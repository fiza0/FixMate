<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Add User') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-lg sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" value="Name" />
                            <x-text-input name="name" required class="block mt-1 w-full" :value="old('name')" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="email" value="Email" />
                            <x-text-input type="email" name="email" required class="block mt-1 w-full" :value="old('email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="password" value="Password" />
                            <x-text-input type="password" name="password" required class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="password_confirmation" value="Confirm Password" />
                            <x-text-input type="password" name="password_confirmation" required class="block mt-1 w-full" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="role" value="Role" />
                            <select name="role" required class="block mt-1 w-full border rounded">
                                <option value="homeowner" {{ old('role') === 'homeowner' ? 'selected' : '' }}>Homeowner</option>
                                <option value="handyman" {{ old('role') === 'handyman' ? 'selected' : '' }}>Handyman</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox" name="active" {{ old('active') ? 'checked' : '' }}>
                                <span class="ml-2">Active</span>
                            </label>
                        </div>
                        <div class="flex justify-end">
                            <x-primary-button>{{ __('Add User') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
