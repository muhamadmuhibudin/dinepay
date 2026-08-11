@include('customer.layouts.__header')

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End --> 

    @include('customer.layouts.__navbar')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">@yield('page_title')</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item active text-primary">@yield('page_subtitle')</li>
        </ol>
    </div>

    <!-- Single Page Header End -->

    @yield('content')

    @include('customer.layouts.__footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- Vite JavaScript -->
    @vite(['resources/assets/customer/js/app.js'])

    <script>
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    @stack('scripts')
    @yield('scripts')
</body>
</html>
