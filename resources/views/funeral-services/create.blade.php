<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ gettext('New Funeral Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('funeral-services.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Verstorbene Person -->
                    <div class="bg-white p-6 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Deceased Person') }}</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="deceased_first_name" :value="gettext('First Name')" />
                                <x-text-input id="deceased_first_name" name="deceased_first_name" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('deceased_first_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="deceased_last_name" :value="gettext('Last Name')" />
                                <x-text-input id="deceased_last_name" name="deceased_last_name" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('deceased_last_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="date_of_death" :value="gettext('Date of Death')" />
                                <x-text-input id="date_of_death" name="date_of_death" type="date" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="deceased_address_street" :value="gettext('Street')" />
                                <x-text-input id="deceased_address_street" name="deceased_address_street" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="deceased_address_house_number" :value="gettext('House Number')" />
                                <x-text-input id="deceased_address_house_number" name="deceased_address_house_number" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="deceased_address_postal_code" :value="gettext('Postal Code')" />
                                <x-text-input id="deceased_address_postal_code" name="deceased_address_postal_code" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="deceased_address_city" :value="gettext('City')" />
                                <x-text-input id="deceased_address_city" name="deceased_address_city" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="deceased_address_state" :value="gettext('State')" />
                                <x-text-input id="deceased_address_state" name="deceased_address_state" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="deceased_address_country" :value="gettext('Country')" />
                                <x-text-input id="deceased_address_country" name="deceased_address_country" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="deceased_address_additional_info" :value="gettext('Address Line 2')" />
                                <x-text-input id="deceased_address_additional_info" name="deceased_address_additional_info" type="text" class="mt-1 block w-full" />
                            </div>
                        </div>
                    </div>

                    <!-- Auftraggeber -->
                    <div class="bg-white p-6 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Customer (Relative)') }}</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="customer_first_name" :value="gettext('First Name')" />
                                <x-text-input id="customer_first_name" name="customer_first_name" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('customer_first_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="customer_last_name" :value="gettext('Last Name')" />
                                <x-text-input id="customer_last_name" name="customer_last_name" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('customer_last_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="customer_email" :value="gettext('Email')" />
                                <x-text-input id="customer_email" name="customer_email" type="email" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="customer_address_street" :value="gettext('Street')" />
                                <x-text-input id="customer_address_street" name="customer_address_street" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="customer_address_house_number" :value="gettext('House Number')" />
                                <x-text-input id="customer_address_house_number" name="customer_address_house_number" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="customer_address_postal_code" :value="gettext('Postal Code')" />
                                <x-text-input id="customer_address_postal_code" name="customer_address_postal_code" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="customer_address_city" :value="gettext('City')" />
                                <x-text-input id="customer_address_city" name="customer_address_city" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="customer_address_state" :value="gettext('State')" />
                                <x-text-input id="customer_address_state" name="customer_address_state" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="customer_address_country" :value="gettext('Country')" />
                                <x-text-input id="customer_address_country" name="customer_address_country" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="customer_address_additional_info" :value="gettext('Address Line 2')" />
                                <x-text-input id="customer_address_additional_info" name="customer_address_additional_info" type="text" class="mt-1 block w-full" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bestattungsdetails -->
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Funeral Details') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="funeral_type" :value="gettext('Funeral Type')" />
                            <select id="funeral_type" name="funeral_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Erdbestattung">{{ gettext('Burial') }}</option>
                                <option value="Feuerbestattung">{{ gettext('Cremation') }}</option>
                                <option value="Seebestattung">{{ gettext('Sea Burial') }}</option>
                                <option value="Waldbestattung">{{ gettext('Forest Burial') }}</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="funeral_date" :value="gettext('Planned Date')" />
                            <x-text-input id="funeral_date" name="funeral_date" type="date" class="mt-1 block w-full" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <x-secondary-button onclick="window.history.back()" class="mr-3">
                        {{ gettext('Cancel') }}
                    </x-secondary-button>
                    <x-primary-button>
                        {{ gettext('Create Order') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
