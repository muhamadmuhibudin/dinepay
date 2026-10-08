@extends('admin.layouts.master')

@section('title', 'Edit Category')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Category</h3>
                <p class="text-subtitle text-muted">Edit Category</p>
            </div>
        </div>
    </div>x
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Category Details</h4>
            </div>
            <div class="card-body">
                
                @if($errors->any() || session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading">Error!</h5>
                        @if($errors->any())
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li><i class="bi bi-exclamation-circle"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if(session('error'))
                            <strong><i class="bi bi-exclamation-triangle"></i> {{ session('error') }}</strong>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cat_name">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('cat_name') is-invalid @enderror" id="cat_name" name="cat_name" placeholder="e.g. Main Course" value="{{ old('cat_name', $category->cat_name) }}" required>
                                @error('cat_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter category description...">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light-secondary me-2">Cancel</a>
                            <button type="reset" class="btn btn-light-secondary me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>
@endsection