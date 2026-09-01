@extends('customer.layouts.master')

@section('page_title', 'Order Confirmation')
@section('page_subtitle', 'Receipt and order summary')

@section('content')
<div class="container-fluid py-5" style="background-color: #f8f9fa;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    
                    <!-- Card Header & Status -->
                    <div class="card-header bg-white text-center border-0 pt-4 pb-2">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle mb-3" style="width: 72px; height: 72px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#198754" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-2 text-dark">Order Confirmed!</h3>

                        @if($order->payment_method === 'cash' && $order->status === 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold">
                                Awaiting Cashier Confirmation
                            </span>
                        @elseif($order->payment_method === 'qris' && $order->status === 'pending')
                            <span class="badge bg-danger px-3 py-2 rounded-pill fw-semibold">
                                Awaiting Payment
                            </span>
                        @else
                            <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold">
                                Payment Successful
                            </span>
                        @endif

                        <p class="text-muted small mt-2 mb-0">Your order has been sent to the kitchen and is being prepared.</p>
                    </div>

                    <!-- Digital Receipt / Order Details -->
                    <div class="card-body px-4 py-3">
                        <div class="bg-light p-3 rounded-3 mb-4 border">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Order ID</span>
                                <span class="fw-bold text-dark small font-monospace">{{ $order->order_code }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Table</span>
                                <span class="fw-semibold text-dark small">Table {{ $order->table_number }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Customer</span>
                                <span class="fw-semibold text-dark small">{{ $order->user->fullname ?? 'Guest' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Payment Method</span>
                                <span class="badge bg-primary text-uppercase">{{ $order->payment_method }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">Order Time</span>
                                <span class="text-muted small">{{ $order->created_at ? $order->created_at->format('M d, Y - H:i') : now()->format('M d, Y - H:i') }}</span>
                            </div>
                        </div>

                        <!-- Order Item Summary -->
                        <h6 class="fw-bold text-dark mb-3">Order Summary</h6>
                        <div class="table-responsive mb-3">
                            <table class="table table-borderless table-sm mb-0">
                                <tbody>
                                    @foreach($orderItems as $item)
                                        <tr class="border-bottom">
                                            <td class="ps-0 py-2">
                                                <span class="fw-semibold text-dark d-block">{{ $item->item->name ?? 'Menu Item' }}</span>
                                                <span class="text-muted small">{{ $item->quantity }}x ${{ number_format($item->price, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="text-end pe-0 py-2 fw-semibold text-dark align-middle">
                                                ${{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Cost Breakdown -->
                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Subtotal</span>
                                <span class="fw-semibold text-dark small">${{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Tax (10%)</span>
                                <span class="fw-semibold text-dark small">${{ number_format($order->tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="fw-bold text-dark fs-5">Grand Total</span>
                                <span class="fw-bold text-success fs-5">${{ number_format($order->grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if($order->note)
                            <div class="alert alert-light border mt-3 mb-0 p-2 small">
                                <strong class="text-muted d-block">Special Note:</strong>
                                {{ $order->note }}
                            </div>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <div class="card-footer bg-white border-0 p-4 pt-0">
                        <div class="d-grid gap-2">
                            <a href="{{ url('/menu?table=' . ($order->table_number ?? 1)) }}" class="btn btn-primary btn-lg rounded-pill fw-semibold shadow-sm text-uppercase">
                                Order More Items
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection