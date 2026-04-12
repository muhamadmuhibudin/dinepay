@extends('customer.layouts.master')

@section('content')
<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-3">
                    <div class="col-lg">
                        <div class="row g-4 justify-content-center">
                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="https://images.unsplash.com/photo-1591325418441-ff678baf78ef" class="img-fluid w-100 rounded-top" alt="">
                                    </div>
                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Food</div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Ichiraku Ramen</h4>
                                        <p class="text-limited">bowl of authentic Japanese noodles with rich broth, tender toppings, and fresh ingredients, perfect for warming your day!</p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-dark fs-5 fw-bold mb-0">Rp25.000,00</p>
                                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="https://images.unsplash.com/photo-1564489563601-c53cfc451e93?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid w-100 rounded-top" alt="">
                                    </div>
                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Food</div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Sushi Platter</h4>
                                        <p class="text-limited">Delicious assortment of fresh sushi rolls and sashimi.</p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-dark fs-5 fw-bold mb-0">Rp50.000,00</p>
                                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="https://images.unsplash.com/photo-1683315446874-e6a629087ef8" class="img-fluid w-100 rounded-top" alt="">
                                    </div>
                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Food</div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Grilled Steak</h4>
                                        <p class="text-limited">Juicy grilled steak with a side of vegetables.</p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-dark fs-5 fw-bold mb-0">Rp75.000,00</p>
                                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="https://images.unsplash.com/photo-1650460069032-3c410224fe55?q=80&w=1931&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid w-100 rounded-top" alt="">
                                    </div>
                                    <div class="text-white bg-info px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Drink</div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Fresh Orange Juice</h4>
                                        <p class="text-limited">Refreshing orange juice made from freshly squeezed oranges.</p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-dark fs-5 fw-bold mb-0">Rp15.000,00</p>
                                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="https://images.unsplash.com/photo-1579954115545-a95591f28bfc?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid w-100 rounded-top" alt="">
                                    </div>
                                    <div class="text-white bg-info px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Drink</div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Strawberry Smoothie</h4>
                                        <p class="text-limited">Delicious strawberry smoothie made with fresh strawberries and yogurt.</p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-dark fs-5 fw-bold mb-0">Rp20.000,00</p>
                                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="https://images.unsplash.com/photo-1653852883277-c4b4b9e020e5?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid w-100 rounded-top" alt="">
                                    </div>
                                    <div class="text-white bg-info px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Drink</div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Chocolate Milkshake</h4>
                                        <p class="text-limited">Rich and creamy chocolate milkshake topped with whipped cream.</p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-dark fs-5 fw-bold mb-0">Rp25.000,00</p>
                                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fruits Shop End-->
@endsection
