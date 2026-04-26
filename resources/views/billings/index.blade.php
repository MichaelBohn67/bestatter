<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ gettext('Billing Data') }}
            </h2>
            <a href="{{ route('billings.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ gettext('Create New') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @php
                        $statusLabels = [
                            'draft' => gettext('Draft'),
                            'sent' => gettext('Sent'),
                            'paid' => gettext('Paid'),
                            'cancelled' => gettext('Cancelled'),
                        ];
                    @endphp

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">{{ gettext('Invoice No.') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ gettext('Order') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ gettext('Deceased Person') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ gettext('Status') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ gettext('Total') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ gettext('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($billings as $billing)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $billing->invoice_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $billing->funeralService?->order_number ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $billing->funeralService?->deceased?->full_name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $statusLabels[$billing->status] ?? $billing->status }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $billing->total ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('billings.edit', $billing) }}" class="font-medium text-blue-600 hover:underline">{{ gettext('Edit') }}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="6" class="px-6 py-4 text-center">{{ gettext('No billing records available.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $billings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
