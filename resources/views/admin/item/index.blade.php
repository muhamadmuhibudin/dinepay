@extends('admin.layouts.master')
@section('title', 'Menu Items')

@section('css')
<link rel="stylesheet" href="{{'assets/admin/extensions/simple-datatables/style.css'}}">
<link rel="stylesheet" href="{{'assets/admin/static/css/compiled/css/datatable.css'}}">
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Menu</h3>
                <p class="text-subtitle text-muted">Manage your menu items here.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('admin.items.create') }}" class="btn btn-primary float-lg-end">
                    <i class="bi bi-plus"></i>
                    Add Menu Item
                </a>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Menu Items
                </h5>
            </div>
            <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-check-circle"></i> {{session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>
                                    @if ($item->img && file_exists(public_path('img_item_upload/' . $item->img)))
                                        <img src="{{ asset('img_item_upload/' . $item->img) }}" alt="{{ $item->name }}" class="img-fluid rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->name) }}&background=random" alt="{{ $item->name }}" class="img-fluid rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    @endif
                                </td>                   
                                <td>{{ $item->name }}</td>
                                <td>{{ Str::limit($item->description, 50) }}</td>
                                <td>{{ '$' . number_format($item->price, 0) }}</td>
                                <td>
                                    <span class="badge {{ $item->category->cat_name == 'Food' ? 'bg-primary' : 'bg-info' }}">
                                        {{ $item->category->cat_name}}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $item->is_active == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->is_active == 1 ? 'Active' : 'Inactive'}}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-warning btn-sm ">
                                        <i class="bi bi-pencil">Edit</i>
                                    </a>
                                    <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
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
<script src="{{'assets/admin/extensions/simple-datatables/umd/simple-datatables.js'}}"></script>
<script src="{{'assets/admin/static/js/pages/simple-datatables.js'}}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete')) {
            e.preventDefault();
            
            const form = e.target.closest('.form-delete');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#435ebe',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            })
        }
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: true,
            timer: 3000,
            confirmButtonColor: '#35dc54',
            confirmButtonText: 'Ok'
        });
    @endif
</script>
@endsection