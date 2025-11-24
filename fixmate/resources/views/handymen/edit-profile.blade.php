<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Handyman Profile') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-3 text-green-700 bg-green-100 border border-green-200 rounded-md px-3 py-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('handyman.profile.update') }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="skill_category" value="Skill Category"/>
<select name="skill_category" id="skill_category" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
    <option value="">Select a category</option>
    @foreach(['plumber', 'electrician', 'carpenter', 'mechanic', 'painter', 'general'] as $cat)
        <option value="{{ $cat }}" {{ old('skill_category', $profile->skill_category) == $cat ? 'selected' : '' }}>
            {{ ucfirst($cat) }}
        </option>
    @endforeach
</select>
<x-input-error :messages="$errors->get('skill_category')" class="mt-2" />

                        </div>
                        <div class="mb-4">
                            <x-input-label for="location" value="Location"/>
                            <x-text-input type="text" name="location" :value="old('location', $profile->location)" class="block mt-1 w-full" required/>
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="bio" value="Bio"/>
                            <textarea name="bio" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('bio', $profile->bio) }}</textarea>
                            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="min_rate" value="Minimum Rate"/>
                            <x-text-input type="number" name="min_rate" :value="old('min_rate', $profile->min_rate)" class="block mt-1 w-full"/>
                            <x-input-error :messages="$errors->get('min_rate')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="max_rate" value="Maximum Rate"/>
                            <x-text-input type="number" name="max_rate" :value="old('max_rate', $profile->max_rate)" class="block mt-1 w-full"/>
                            <x-input-error :messages="$errors->get('max_rate')" class="mt-2" />
                        </div>
                        <div>
                            <x-primary-button>{{ __('Save Profile') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
