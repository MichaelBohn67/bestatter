@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Billing</h1>

            @if(isset($billing))
            <div class="card">
                <div class="card-header">
                    <h3>Billing Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Funeral Service Information</h4>
                            <p><strong>Order Number:</strong> {{ $billing->funeralService->order_number }}</p>
                            <p><strong>Status:</strong> {{ $billing->funeralService->status }}</p>
                            <p><strong>Funeral Date:</strong> {{
                                $billing->funeralService->funeral_date?->format('d.m.Y') }}</p>
                            <p><strong>Deceased:</strong> {{ $billing->funeralService->deceased->full_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h4>Customer Information</h4>
                            <p><strong>Name:</strong> {{ $billing->funeralService->customer->full_name }}</p>
                            <p><strong>Email:</strong> {{ $billing->funeralService->customer->email }}</p>
                            <p><strong>Phone:</strong> {{ $billing->funeralService->customer->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-info">
                No billing information available.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
