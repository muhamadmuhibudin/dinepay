@extends('admin.layouts.master')

@section('title', 'Add Menu Item')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Menu Data</h3>
                <p class="text-subtitle text-muted">Edit the details of your menu item.</p>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Item Details</h4>
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
                <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group fw-bold mb-4">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="e.g. Special Fried Rice" value="{{ old('name', $item->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group fw-bold mb-4">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="" disabled>-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->cat_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group fw-bold mb-4">
                                <label for="price">Price ($) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="0.00" step="0.01" value="{{ old('price', $item->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                       <div class="col-md-6">
                            <div class="form-group fw-bold mb-4">
                                <label for="img_item">Image</label>
                                
                                <div class="mb-3">
                                    @if ($item->img && file_exists(public_path('img_item_upload/' . $item->img)))
                                        <img src="{{ asset('img_item_upload/' . $item->img) }}" alt="{{ $item->name }}" class="img-fluid rounded border" style="max-height: 100px; object-fit: cover;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->name) }}&background=random" alt="{{ $item->name }}" class="img-fluid rounded border" style="max-height: 100px;">
                                    @endif
                                </div>

                                <input type="file" class="form-control @error('img_item') is-invalid @enderror" id="img_item" name="img_item" accept="image/*">
                                
                                @error('img_item')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <small class="text-muted">Leave blank if you don't want to change the image. Recommended size: 500x500px (Max 2MB)</small>
                                @enderror
                            </div>

                            <div class="form-group fw-bold mb-4">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter item description...">{{ old('description', $item->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group fw-bold mb-4">
                                <label for="status">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" id="flexSwitchCheckChecked" name="is_active" value="1" {{ old('is_active', $item->is_active) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Active / Inactive</label>
                                    @error('is_active')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-light-secondary me-2">Cancel</a>
                            <button type="reset" class="btn btn-light-secondary me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Save Item</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>
@endsection