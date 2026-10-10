@extends('admin.layouts.master')
@section('title', 'Order Detail')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Order Detail: {{ $order->order_code }}</h3>
                <p class="text-subtitle text-muted">Complete details for this transaction.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light-secondary float-lg-end">
                    <i class="bi bi-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>

    <!-- Section 1: Order Information -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Order Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%">Order Code</th>
                                <td>: <span class="badge bg-secondary">{{ $order->order_code }}</span></td>
                            </tr>
                            <tr>
                                <th>Customer Name</th>
                                <td>: {{ $order->user->fullname ?? 'Walk-in Customer' }}</td>
                            </tr>
                            <tr>
                                <th>Table Number</th>
                                <td>: {{ $order->table_number }}</td>
                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <td>: {{ $order->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%">Order Status</th>
                                <td>: 
                                    @php
                                        $statusColor = match($order->status) {
                                            'pending' => 'bg-warning',
                                            'processing' => 'bg-info',
                                            'settlement' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusColor }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>: {{ strtoupper($order->payment_method) }}</td>
                            </tr>
                            <tr>
                                <th>Payment Status</th>
                                <td>: 
                                    <span class="badge {{ $order->payment_status == 'pending' ? 'bg-warning' : 'bg-success' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Note</th>
                                <td>: {{ $order->note ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Order Items -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Order Details</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Tax</th>
                                <th class="text-end">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->item->name ?? 'Unknown Item' }}</td>
                                    <td class="text-center">$ {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">$ {{ number_format($item->tax, 0, ',', '.') }}</td>
                                    <td class="text-end">$ {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No items found for this order.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Subtotal :</th>
                                <th class="text-end">$ {{ number_format($order->subtotal, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-end">Tax :</th>
                                <th class="text-end">$ {{ number_format($order->tax, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-end fs-5">Grand Total :</th>
                                <th class="text-end fs-5 text-success">$ {{ number_format($order->grand_total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection