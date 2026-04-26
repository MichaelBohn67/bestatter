<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ gettext('Create Deceased Person') }}
            </h2>
            <a href="{{ route('deceased.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ gettext('Back to Overview') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('deceased.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Personal Details') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <x-input-label for="date_of_birth" :value="gettext('Date of Birth')" />
                            <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" value="{{ old('date_of_birth') }}" />
                        </div>
                        <div>
                            <x-input-label for="date_of_death" :value="gettext('Date of Death')" />
                            <x-text-input id="date_of_death" name="date_of_death" type="date" class="mt-1 block w-full" value="{{ old('date_of_death') }}" />
                        </div>
                        <div>
                            <x-input-label for="place_of_death" :value="gettext('Place of Death')" />
                            <x-text-input id="place_of_death" name="place_of_death" type="text" class="mt-1 block w-full" value="{{ old('place_of_death') }}" />
                        </div>
                        <div>
                            <x-input-label for="religion" :value="gettext('Religion')" />
                            <x-text-input id="religion" name="religion" type="text" class="mt-1 block w-full" value="{{ old('religion') }}" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="last_address" :value="gettext('Last Address')" />
                            <x-text-input id="last_address" name="last_address" type="text" class="mt-1 block w-full" value="{{ old('last_address') }}" />
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
