@extends('customer.layouts.master')

@section('page_title', 'Your Cart')
@section('page_subtitle', 'Review and manage your selected items')

@section('content')
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
                            <th>Image</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
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
                                    <img src="{{ isset($item['img']) && $item['img'] ? (str_starts_with($item['img'], 'http') ? $item['img'] : asset('img_item_upload/' . $item['img'])) : asset('assets/admin/static/images/samples/error-404.svg') }}"
                                                    class="img-fluid rounded-circle"
                                                    style="width:48px; height:48px; object-fit: cover;"
                                                    alt="{{ $item['name'] }}">
                                </td>

                                <td>{{ $item['name'] }}</td>
                                <td>${{ number_format($item['price'], 2, '.', ',') }}</td>
                                <td>
                                    <div class="input-group" style="width:120px;">
                                        <button class="btn btn-sm btn-outline-secondary"
                                                onclick="updateQuantity({{ $item['id'] }}, -1)">-</button>
                                        <input id="qty-{{ $item['id'] }}"
                                               type="number"
                                               class="form-control form-control-sm text-center"
                                               value="{{ $item['qty'] }}"
                                               readonly>
                                        <button class="btn btn-sm btn-outline-secondary"
                                                onclick="updateQuantity({{ $item['id'] }}, 1)">+</button>
                                    </div>
                                </td>
                                <td>${{ number_format($itemTotal, 2, '.', ',') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="confirmRemove({{ $item['id'] }})">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row g-4 justify-content-end mt-1">
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h2 class="display-6 mb-4">Order <span class="fw-normal">Summary</span></h2>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal</h5>
                                <p class="mb-0">${{ number_format($subtotal, 2, '.', ',') }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0 me-4">Tax (10%)</p>
                                <p class="mb-0">${{ number_format($subtotal * 0.1, 2, '.', ',') }}</p>
                            </div>
                        </div>
                        <div class="py-4 mb-4 border-top d-flex justify-content-between">
                            <h4 class="mb-0 ps-4 me-4">Total</h4>
                            <h5 class="mb-0 pe-4">${{ number_format($subtotal * 1.1, 2, '.', ',') }}</h5>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('checkout') }}" class="btn border-secondary py-3 text-primary text-uppercase mb-4">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateQuantity(itemId, change) {
    const qtyInput = document.getElementById('qty-' + itemId);
    let currentQty = parseInt(qtyInput.value);
    let newQty = currentQty + change;

    if (newQty < 1) {
        // Trigger SweetAlert confirmation when quantity drops below 1
        confirmRemove(itemId);
        return;
    }

    fetch("{{ url('/cart/update') }}/" + itemId, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ qty: newQty })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            qtyInput.value = newQty;
            window.location.reload();
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

function confirmRemove(itemId) {
    // SweetAlert2 confirmation modal with Yes/No buttons
    Swal.fire({
        title: 'Remove this item?',
        text: "You can always add it back to your cart later.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            removeFromCart(itemId);
        }
    });
}

function removeFromCart(itemId) {
    fetch("{{ url('/cart/remove') }}/" + itemId, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}
</script>
@endpush
