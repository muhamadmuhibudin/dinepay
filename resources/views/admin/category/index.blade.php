@extends('admin.layouts.master')
@section('title', 'Category Management')

@section('css')
<link rel="stylesheet" href="{{'assets/admin/extensions/simple-datatables/style.css'}}">
<link rel="stylesheet" href="{{'assets/admin/static/css/compiled/css/datatable.css'}}">
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Category Management</h3>
                <p class="text-subtitle text-muted">Manage your categories here.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary float-lg-end">
                    <i class="bi bi-plus"></i>
                    Add Category
                </a>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Category Management
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
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $category->cat_name }}</td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm ">
                                        <i class="bi bi-pencil">Edit</i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline form-delete">
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

@endsection