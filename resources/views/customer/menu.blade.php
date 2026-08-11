@extends('customer.layouts.master')

@section('page_title', 'Our Menu')
@section('page_subtitle', 'Please choose your favorite menu')

@section('content')
<!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-3">
                            <div class="col-lg">
                                <div class="row g-4 justify-content-center">

                                @foreach($items as $item)
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="{{ $item->img ? (str_starts_with($item->img, 'http') ? $item->img : asset('img_item_upload/' . $item->img)) : asset('assets/admin/static/images/samples/error-404.svg') }}"
                                                    class="img-fluid w-100 rounded-top"
                                                    style="height: 250px; object-fit: cover;"
                                                    alt="{{ $item->name }}">
                                            </div>
                                                
                                            <div class="text-white px-3 py-1 rounded position-absolute 
                                                 @if($item->category->cat_name == 'Food') bg-success
                                                @elseif($item->category->cat_name == 'Drink') bg-info
                                                @else bg-primary
                                                @endif" style="top:10px; left:10px;">
                                                {{ $item->category->cat_name }}</div>

                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{$item->name}}</h4>
                                                <p class="text-limited">{{$item->description}}</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                    {{ '$' . number_format($item->price, 0, ',', '.') }}</p>
                                                    <button type="button" onclick="addToCart({{$item->id}})" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                                        Add to Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->
@push('scripts')
<script>
function addToCart(menuId) {
    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ id: menuId })
    })
    .then(response => response.json())
    .then(data => {
        // Display SweetAlert toast for successful addition
        Swal.fire({
            title: 'Success!',
            text: data.message,
            icon: 'success',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        });
    })
    .catch(error => {
        console.error("Error:", error);
        // Display SweetAlert toast for error handling
        Swal.fire({
            title: 'Error!',
            text: 'A system error occurred. Please try again.',
            icon: 'error',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
    });
}
</script>
@endpush
@endsection