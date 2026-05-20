@extends('customer.layouts.master')

@section('page_title', 'Checkout')
@section('page_subtitle', 'Review and complete your order details')

@section('content')

<!-- Checkout Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Payment Details</h1>
        <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <div class="row">
                        <div class="col-md-12 col-lg-4">
                            <div class="form-item w-100">
                                <label class="form-label my-3">Full Name<sup>*</sup></label>
                                <input type="text" name="fullname" class="form-control" placeholder="Enter your full name"  required>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="form-item w-100">
                                <label class="form-label my-3">WhatsApp Number<sup>*</sup></label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter your WhatsApp number"  required>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="form-item w-100">
                                <label class="form-label my-3">Table Number<sup>*</sup></label>
                                <input type="text" class="form-control" value="{{ $tableNumber ?? 'Not specified' }}" disabled required>
                            </div>
                        </div>
                    </div>   
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="form-item">
                                <textarea name="note" class="form-control" spellcheck="false" cols="30" rows="5" placeholder="Order notes (Optional)"></textarea>
                            </div>   
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <br><br>
                            <h4 class="mb-4">Order Details</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>

@php $subTotal = 0; @endphp

@foreach (session('cart', []) as $item)

@php
    $quantity = $item['qty'] ?? 1;
    $itemTotal = $item['price'] * $quantity;
    $subTotal += $itemTotal;
@endphp

<tr>
    <td>
        <img src="https://loremflickr.com/80/80/{{ isset($item['category']) && !empty($item['category']) ? strtolower($item['category']) : 'food' }}"
             class="img-fluid rounded-circle"
             style="width:48px; height:48px;"
             alt="{{ $item['name'] }}">
    </td>
    <td>{{ $item['name'] }}</td>

    <td>
        ${{ number_format($item['price'], 0, ',', '.') }}
    </td>

    <td>{{ $quantity }}</td>

    <td>
        ${{ number_format($itemTotal, 0, ',', '.') }}
    </td>
</tr>

@endforeach

</tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @php
                    $subTotal = 0;
                    foreach (session('cart', []) as $item) {
                        $quantity = $item['qty'] ?? 1;
                        $itemTotal = $item['price'] * $quantity;
                        $subTotal += $itemTotal;
                    }
                    $tax = $subTotal * 0.1;
                    $total = $subTotal + $tax;
                @endphp

                <div class="col-md-12 col-lg-6 col-xl-6">
                    <div class="row g-4 align-items-center py-3">
                        <div class="col-lg-12">
                            <div class="bg-light rounded">
                                <div class="p-4">
                                    <h3 class="display-6 mb-4">Order <span class="fw-normal">Summary</span></h3>
                                    <div class="d-flex justify-content-between mb-4">
    <h5 class="mb-0 me-4">Subtotal</h5>
    <p class="mb-0">
        ${{ number_format($subTotal, 0, ',', '.') }}
    </p>
</div>

<div class="d-flex justify-content-between">
    <p class="mb-0 me-4">Tax (10%)</p>
    <div>
        <p class="mb-0">
            ${{ number_format($tax, 0, ',', '.') }}
        </p>
    </div>
</div>
                                </div>
                                <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
    <h4 class="mb-0 ps-4 me-4">Total</h4>

    <h5 class="mb-0 pe-4">
        ${{ number_format($total, 0, ',', '.') }}
    </h5>
</div>

                                <div class="py-4 mb-4 d-flex justify-content-between">
                                    <h5 class="mb-0 ps-4 me-4">Payment Method</h5>
                                    <div class="mb-0 pe-4 mb-3 pe-5">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input bg-primary border-0" id="qris" name="payment_method" value="qris" checked>
                                            <label class="form-check-label" for="qris">QRIS</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input bg-primary border-0" id="cash" name="payment_method" value="cash" >
                                            <label class="form-check-label" for="cash">Cash</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn border-secondary py-3 text-uppercase text-primary">Confirm Order</button> 
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Checkout Page End -->

@endsection
