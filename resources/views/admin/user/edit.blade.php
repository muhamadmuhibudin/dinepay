@extends('admin.layouts.master')

@section('title', 'Edit User')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit User Data</h3>
                <p class="text-subtitle text-muted">Edit user account information</p>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">User Details</h4>
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

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="fullname">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fullname') is-invalid @enderror" id="fullname" name="fullname" placeholder="e.g. John Doe" value="{{ old('fullname', $user->fullname) }}" required>
                                @error('fullname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="e.g. john@example.com" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="role_id">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                    <option value="" disabled>-- Select Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->role_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="e.g. johndoe123" value="{{ old('username', $user->username) }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="e.g. 081234567890" value="{{ old('phone', $user->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Security</h5>

                    <div class="row">
                        <!-- Old Password field -->
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="old_password">Current Password <span class="text-muted fw-normal" style="font-size: 0.85em;">(Required only if you want to change the password)</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" placeholder="Enter current password to authorize changes">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="old_password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @error('old_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- New Password field -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password">New Password <span class="text-muted fw-normal" style="font-size: 0.85em;">(Leave blank to keep current)</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter new password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Confirm New Password field -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password_confirmation">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-type new password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light-secondary me-2">Cancel</a>
                            <button type="reset" class="btn btn-light-secondary me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>
@endsection