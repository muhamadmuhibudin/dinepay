@extends('customer.layouts.master')

@section('page_title', 'Checkout')
@section('page_subtitle', 'Review and complete your order details')

@section('content')
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
                                <input type="text" name="fullname" class="form-control" placeholder="Enter your full name" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="form-item w-100">
                                <label class="form-label my-3">WhatsApp Number<sup>*</sup></label>
                                <input type="tel" name="phone" class="form-control" 
                                    placeholder="Enter your WhatsApp number" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                                    minlength="10" maxlength="15" required>
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
                                                <img src="{{ isset($item['img']) && $item['img'] ? (str_starts_with($item['img'], 'http') ? $item['img'] : asset('img_item_upload/' . $item['img'])) : asset('assets/admin/static/images/samples/error-404.svg') }}"
                                                    class="img-fluid rounded-circle"
                                                    style="width:48px; height:48px; object-fit: cover;"
                                                    alt="{{ $item['name'] }}">
                                            </td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>${{ number_format($item['price'], 0, ',', '.') }}</td>
                                            <td>{{ $quantity }}</td>
                                            <td>${{ number_format($itemTotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @php
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
                                        <p class="mb-0">${{ number_format($subTotal, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0 me-4">Tax (10%)</p>
                                        <div>
                                            <p class="mb-0">${{ number_format($tax, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                    <h4 class="mb-0 ps-4 me-4">Total</h4>
                                    <h5 class="mb-0 pe-4">${{ number_format($total, 0, ',', '.') }}</h5>
                                </div>
                                <div class="py-4 mb-4 d-flex justify-content-between">
                                    <h5 class="mb-0 ps-4 me-4">Payment Method</h5>
                                    <div class="mb-0 pe-4 mb-3 pe-5">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input bg-primary border-0" id="qris" name="payment_method" value="qris" checked>
                                            <label class="form-check-label" for="qris">QRIS</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input bg-primary border-0" id="cash" name="payment_method" value="cash">
                                            <label class="form-check-label" for="cash">Cash</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" id="pay-button" class="btn border-secondary py-3 text-uppercase text-primary">Confirm Order</button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') ?? config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const payButton = document.getElementById("pay-button");
        const form = document.getElementById("checkoutForm");
        let isProcessing = false;

        form.addEventListener("submit", function (e) {
            e.preventDefault(); 
        });

        payButton.addEventListener("click", function (e) {
            e.preventDefault();

            if (isProcessing) return;

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const paymentMethodInput = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethodInput) {
                // Warning alert if no payment method is selected
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please select a payment method.',
                    icon: 'warning',
                    confirmButtonColor: '#0d6efd'
                });
                return;
            }

            const formData = new FormData(form);

            isProcessing = true;
            payButton.disabled = true;
            payButton.innerText = "Processing...";

            fetch("{{ route('checkout.store') }}", {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Server error occurred');
                }
                return data;
            })
            .then(data => {
                // Direct redirect for Cash payment method
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                    return;
                }

                // Trigger Midtrans Snap popup for QRIS
                if (data.snapToken) {
                    window.snap.pay(data.snapToken, {
                        onSuccess: function (result) {
                            window.location.href = "{{ url('/checkout/success') }}/" + data.order_code;
                        },
                        onPending: function (result) {
                            window.location.href = "{{ url('/checkout/success') }}/" + data.order_code;
                        },
                        onError: function (result) {
                            // Error alert from Midtrans
                            Swal.fire({
                                title: 'Payment Failed',
                                text: 'Your transaction could not be completed.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                            resetButton();
                        },
                        onClose: function () {
                            // Info alert if user closes Snap popup
                            Swal.fire({
                                title: 'Payment Cancelled',
                                text: 'You closed the payment window before completing the transaction.',
                                icon: 'info',
                                confirmButtonColor: '#6c757d'
                            });
                            resetButton();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to retrieve payment token.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                    resetButton();
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    title: 'System Error',
                    text: error.message,
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
                resetButton();
            });

            function resetButton() {
                isProcessing = false;
                payButton.disabled = false;
                payButton.innerText = "Confirm Order";
            }
        });
    });
</script>
@endpush
@endsection