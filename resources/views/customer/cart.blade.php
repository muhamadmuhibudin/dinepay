@extends('customer.layouts.master')

@section('content')
<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(empty($cart))
            <h4 class="text-center">Your cart is empty!</h4>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Item</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
    @php $subtotal = 0; @endphp
    @foreach($cart as $item)
        @php
            $itemTotal = $item['price'] * $item['qty'];
            $subtotal += $itemTotal;
        @endphp
        <tr>
            <td>
                <img src="{{ $item['image'] }}" class="img-fluid rounded-circle" style="width:80px; height:80px;" alt="{{ $item['name'] }}">
            </td>
            <td>{{ $item['name'] }}</td>
            <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
            <td>
                <div class="input-group" style="width:120px;">
                    <button class="btn btn-sm btn-outline-secondary"
                            onclick="updateCart({{ $item['id'] }}, {{ $item['qty'] - 1 }})">-</button>
                    <input type="text" class="form-control form-control-sm text-center border-0"
                           value="{{ $item['qty'] }}" readonly>
                    <button class="btn btn-sm btn-outline-secondary"
                            onclick="updateCart({{ $item['id'] }}, {{ $item['qty'] + 1 }})">+</button>
                </div>
            </td>
            <td>Rp{{ number_format($itemTotal, 0, ',', '.') }}</td>
            <td>
                <button class="btn btn-sm btn-danger"
                        onclick="removeFromCart({{ $item['id'] }})">Remove</button>
            </td>
        </tr>
    @endforeach
</tbody>

                </table>
            </div>

            <div class="row g-4 justify-content-end mt-1">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h2 class="display-6 mb-4">Order <span class="fw-normal">Summary</span></h2>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal</h5>
                                <p class="mb-0">Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0 me-4">Tax (10%)</p>
                                <p class="mb-0">Rp{{ number_format($subtotal * 0.1, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="py-4 mb-4 border-top d-flex justify-content-between">
                            <h4 class="mb-0 ps-4 me-4">Total</h4>
                            <h5 class="mb-0 pe-4">Rp{{ number_format($subtotal * 1.1, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="mb-0 mb-3">
                            <a href="{{ route('checkout') }}" class="btn border-secondary py-3 text-primary text-uppercase mb-4" type="button">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- Cart Page End -->

<script>
function updateCart(id, qty) {
    fetch("{{ url('/cart/update') }}/" + id, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ qty: qty })
    })
    .then(res => res.json())
    .then(data => {
        location.reload(); // reload supaya qty & total terupdate
    });
}

function removeFromCart(id) {
    fetch("{{ url('/cart/remove') }}/" + id, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        location.reload();
    });
}
</script>

@endsection
