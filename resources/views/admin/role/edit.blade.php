@extends('admin.layouts.master')

@section('title', 'Edit Role')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Role Data</h3>
                <p class="text-subtitle text-muted">Edit the details of your role.</p>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Role Details</h4>
            </div>
            <div class="card-body">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading">Error!</h5>
                        @foreach ($errors->all() as $error)
                        <li>
                            <i class="bi bi-file-excel"></i> {{ $error }}
                        </li>
                        @endforeach
                            <strong><i class="bi bi-exclamation-triangle"></i> {{session('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group fw-bold mb-4">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="role_name" name="role_name" placeholder="e.g. Special Fried Rice" value="{{ old('role_name', $role->role_name) }}" required>
                                @error('role_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group fw-bold mb-4">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter role description...">{{ old('description', $role->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-light-secondary me-2">Cancel</a>
                            <button type="reset" class="btn btn-light-secondary me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Save role</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>
@endsection