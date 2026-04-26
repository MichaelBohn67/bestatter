<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ gettext('Create Relative') }}
            </h2>
            <a href="{{ route('relatives.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ gettext('Back to Overview') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('relatives.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Personal Details') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-input-label for="deceased_id" :value="gettext('Deceased Person')" />
                            <select id="deceased_id" name="deceased_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ gettext('Please select') }}</option>
                                @foreach($deceased as $person)
                                    <option value="{{ $person->id }}" @selected(old('deceased_id') == $person->id)>
                                        {{ $person->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('deceased_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="first_name" :value="gettext('First Name')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" value="{{ old('first_name') }}" required />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="last_name" :value="gettext('Last Name')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" value="{{ old('last_name') }}" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="relationship" :value="gettext('Relationship')" />
                            <x-text-input id="relationship" name="relationship" type="text" class="mt-1 block w-full" value="{{ old('relationship') }}" />
                        </div>
                        <div>
                            <x-input-label for="phone" :value="gettext('Phone')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone') }}" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="email" :value="gettext('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email') }}" />
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Address') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="address_street" :value="gettext('Street')" />
                            <x-text-input id="address_street" name="address_street" type="text" class="mt-1 block w-full" value="{{ old('address_street') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_house_number" :value="gettext('House Number')" />
                            <x-text-input id="address_house_number" name="address_house_number" type="text" class="mt-1 block w-full" value="{{ old('address_house_number') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_postal_code" :value="gettext('Postal Code')" />
                            <x-text-input id="address_postal_code" name="address_postal_code" type="text" class="mt-1 block w-full" value="{{ old('address_postal_code') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_city" :value="gettext('City')" />
                            <x-text-input id="address_city" name="address_city" type="text" class="mt-1 block w-full" value="{{ old('address_city') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_state" :value="gettext('State')" />
                            <x-text-input id="address_state" name="address_state" type="text" class="mt-1 block w-full" value="{{ old('address_state') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_country" :value="gettext('Country')" />
                            <x-text-input id="address_country" name="address_country" type="text" class="mt-1 block w-full" value="{{ old('address_country') }}" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="address_additional_info" :value="gettext('Address Line 2')" />
                            <x-text-input id="address_additional_info" name="address_additional_info" type="text" class="mt-1 block w-full" value="{{ old('address_additional_info') }}" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-primary-button>
                        {{ gettext('Save') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
