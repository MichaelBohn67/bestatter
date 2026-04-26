<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ gettext('Edit Customer') }}
            </h2>
            <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ gettext('Back to Overview') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('customers.update', $customer) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Contact') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="first_name" :value="gettext('First Name')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" value="{{ old('first_name', $customer->first_name) }}" required />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="last_name" :value="gettext('Last Name')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" value="{{ old('last_name', $customer->last_name) }}" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="gettext('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $customer->email) }}" />
                        </div>
                        <div>
                            <x-input-label for="phone" :value="gettext('Phone')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $customer->phone) }}" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="relationship_to_deceased" :value="gettext('Relationship to the Deceased')" />
                            <x-text-input id="relationship_to_deceased" name="relationship_to_deceased" type="text" class="mt-1 block w-full" value="{{ old('relationship_to_deceased', $customer->relationship_to_deceased) }}" />
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Address') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="address_street" :value="gettext('Street')" />
                            <x-text-input id="address_street" name="address_street" type="text" class="mt-1 block w-full" value="{{ old('address_street', $customer->address->street ?? '') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_house_number" :value="gettext('House Number')" />
                            <x-text-input id="address_house_number" name="address_house_number" type="text" class="mt-1 block w-full" value="{{ old('address_house_number', $customer->address->house_number ?? '') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_postal_code" :value="gettext('Postal Code')" />
                            <x-text-input id="address_postal_code" name="address_postal_code" type="text" class="mt-1 block w-full" value="{{ old('address_postal_code', $customer->address->postal_code ?? '') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_city" :value="gettext('City')" />
                            <x-text-input id="address_city" name="address_city" type="text" class="mt-1 block w-full" value="{{ old('address_city', $customer->address->city ?? '') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_state" :value="gettext('State')" />
                            <x-text-input id="address_state" name="address_state" type="text" class="mt-1 block w-full" value="{{ old('address_state', $customer->address->state ?? '') }}" />
                        </div>
                        <div>
                            <x-input-label for="address_country" :value="gettext('Country')" />
                            <x-text-input id="address_country" name="address_country" type="text" class="mt-1 block w-full" value="{{ old('address_country', $customer->address->country ?? '') }}" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="address_additional_info" :value="gettext('Address Line 2')" />
                            <x-text-input id="address_additional_info" name="address_additional_info" type="text" class="mt-1 block w-full" value="{{ old('address_additional_info', $customer->address->additional_info ?? '') }}" />
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
