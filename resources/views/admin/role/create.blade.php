@extends('admin.layouts.master')

@section('title', 'Add Menu role')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Add Role</h3>
                <p class="text-subtitle text-muted">Create a new role</p>
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
                <form action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Role Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('role_name') is-invalid @enderror" id="role_name" name="role_name" placeholder="e.g. Administrator" value="{{ old('role_name') }}" required>
                                @error('role_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter role description...">{{ old('description') }}</textarea>
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