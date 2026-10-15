@extends('admin.layouts.master')
@section('title', 'Orders')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/static/css/compiled/css/datatable.css') }}">
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Orders</h3>
                <p class="text-subtitle text-muted">Manage your orders here.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('admin.orders.create') }}" class="btn btn-primary float-lg-end">
                    <i class="bi bi-plus"></i>
                    Add Order
                </a>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Orders
                </h5>
            </div>
            <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-check-circle"></i> {{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order Code</th>
                            <th>Customer Name</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Table Number</th>
                            <th>Payment Method</th>
                            <th>Notes</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $order->order_code }}</span></td>
                                <td>{{ $order->user->fullname }}</td>
                                <td>$ {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                
                                <td>
                                    @php
                                        $badgeColor = match($order->status) {
                                            'pending' => 'bg-warning',
                                            'processing' => 'bg-info',
                                            'booked' => 'bg-primary',
                                            'settlement' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeColor }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                
                                <td>{{ $order->table_number }}</td>
                                <td>{{ strtoupper($order->payment_method) }}</td>
                                <td>{{ Str::limit($order->note, 30) ?: '-' }}</td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                
                                <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm mb-1">
                                    <i class="bi bi-eye"> Show</i>
                                </a>
                                
                                @if(Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Cashier')
                                    @if($order->status === 'pending' && strtolower($order->payment_method) === 'cash')
                                        <form action="{{ route('admin.orders.settlement', $order->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm mb-1">
                                                <i class="bi bi-check"> Confirm Payment</i>
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                @if(Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Chef')
                                    @if($order->status === 'settlement')
                                        <form action="{{ route('admin.orders.process', $order->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-warning btn-sm mb-1">
                                                <i class="bi bi-fire"> Cooked</i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/static/js/pages/simple-datatables.js') }}"></script>
@endsection