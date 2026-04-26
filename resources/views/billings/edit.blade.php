<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ gettext('Edit Billing Data') }}
            </h2>
            <a href="{{ route('billings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ gettext('Back to Overview') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('billings.update', $billing) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Assignment') }}</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <x-input-label for="funeral_service_id" :value="gettext('Funeral Order')" />
                            <select id="funeral_service_id" name="funeral_service_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ gettext('Please select') }}</option>
                                @foreach($funeralServices as $service)
                                    <option value="{{ $service->id }}" @selected(old('funeral_service_id', $billing->funeral_service_id) == $service->id)>
                                        {{ $service->order_number }} - {{ $service->deceased?->full_name ?? gettext('Unknown') }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('funeral_service_id')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ gettext('Invoice') }}</h3>
                    @php
                        $statusLabels = [
                            'draft' => gettext('Draft'),
                            'sent' => gettext('Sent'),
                            'paid' => gettext('Paid'),
                            'cancelled' => gettext('Cancelled'),
                        ];
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="invoice_number" :value="gettext('Invoice Number')" />
                            <x-text-input id="invoice_number" name="invoice_number" type="text" class="mt-1 block w-full" value="{{ old('invoice_number', $billing->invoice_number) }}" required />
                            <x-input-error :messages="$errors->get('invoice_number')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="status" :value="gettext('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach(['draft', 'sent', 'paid', 'cancelled'] as $value)
                                    <option value="{{ $value }}" @selected(old('status', $billing->status) === $value)>
                                        {{ $statusLabels[$value] ?? $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="issued_at" :value="gettext('Invoice Date')" />
                            <x-text-input id="issued_at" name="issued_at" type="date" class="mt-1 block w-full" value="{{ old('issued_at', $billing->issued_at?->format('Y-m-d')) }}" />
                        </div>
                        <div>
                            <x-input-label for="due_at" :value="gettext('Due Date')" />
                            <x-text-input id="due_at" name="due_at" type="date" class="mt-1 block w-full" value="{{ old('due_at', $billing->due_at?->format('Y-m-d')) }}" />
                        </div>
                        <div>
                            <x-input-label for="subtotal" :value="gettext('Subtotal')" />
                            <x-text-input id="subtotal" name="subtotal" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('subtotal', $billing->subtotal) }}" />
                        </div>
                        <div>
                            <x-input-label for="tax_rate" :value="gettext('VAT (%)')" />
                            <x-text-input id="tax_rate" name="tax_rate" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('tax_rate', $billing->tax_rate) }}" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="notes" :value="gettext('Notes')" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('notes', $billing->notes) }}</textarea>
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
