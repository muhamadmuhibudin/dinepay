@extends('customer.layouts.master')

@section('content')
<!-- Cart Start -->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-12">
                <h2 class="mb-4">Shopping Cart</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Your cart is empty</p>
                                    <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection