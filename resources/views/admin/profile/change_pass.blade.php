@extends('admin.layouts.master')
@section('module', 'Admin')
@section('action', 'Change Password')

@section('admin-content')

    <h2 class="section-title">Hello, {{ Auth::user()->name }}!</h2>
    <p class="section-lead">
        You can update your personal password here.
    </p>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form id="change-password-form" action="{{ route('admin.update.password') }}" method="POST"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="card-header">
                        <h4>Edit Password</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <!-- Current Password -->
                            <div class="form-group col-md-12 col-12 position-relative">
                                <label>Current Password</label>
                                <input type="password" name="old_password"
                                    class="form-control @error('old_password') is-invalid @enderror" required
                                    placeholder="Enter your current password">
                                <i class="fas fa-eye toggle-password"
                                    style="position:absolute; top:38px; right:15px; cursor:pointer;"></i>
                                <div class="invalid-feedback">Please enter your current password.</div>
                                @error('old_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="form-group col-md-12 col-12 position-relative">
                                <label>New Password</label>
                                <input type="password" name="new_password" id="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror" required
                                    placeholder="Enter your new password">
                                <i class="fas fa-eye toggle-password"
                                    style="position:absolute; top:38px; right:15px; cursor:pointer;"></i>
                                <div class="invalid-feedback">Please enter a new password.</div>
                                @error('new_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small id="passwordStrength" class="form-text text-muted mt-1"></small>
                            </div>

                            <!-- Confirm New Password -->
                            <div class="form-group col-md-12 col-12 position-relative">
                                <label>Confirm New Password</label>
                                <input type="password" name="new_password_confirmation"
                                    class="form-control @error('new_password_confirmation') is-invalid @enderror" required
                                    placeholder="Re-enter your new password">
                                <i class="fas fa-eye toggle-password"
                                    style="position:absolute; top:38px; right:15px; cursor:pointer;"></i>
                                <div class="invalid-feedback">Please confirm your new password.</div>
                                @error('new_password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const form = $('#change-password-form');
            const btn = $('#saveBtn');
            const strengthText = $('#passwordStrength');

            // Password strength meter
            $('#new_password').on('input', function() {
                const val = $(this).val();
                let strength = 'Weak';
                let color = 'text-danger';

                if (val.length >= 8 && /[A-Z]/.test(val) && /[0-9]/.test(val) && /[!@#$%^&*]/.test(val)) {
                    strength = 'Strong';
                    color = 'text-success';
                } else if (val.length >= 6) {
                    strength = 'Medium';
                    color = 'text-warning';
                }

                strengthText.text('Strength: ' + strength)
                    .removeClass('text-danger text-warning text-success')
                    .addClass(color);
            });

            // Toggle show/hide password
            $('.toggle-password').on('click', function() {
                const input = $(this).siblings('input');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Form submit
            form.on('submit', function(e) {
                e.preventDefault();

                const oldPass = form.find('[name="old_password"]').val().trim();
                const newPass = form.find('[name="new_password"]').val().trim();
                const confirmPass = form.find('[name="new_password_confirmation"]').val().trim();

                // Client-side validation
                if (!oldPass || !newPass || !confirmPass) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Information',
                        text: 'Please fill all password fields.'
                    });
                    return;
                }

                if (newPass !== confirmPass) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Password Mismatch',
                        text: 'New password and confirmation do not match.'
                    });
                    return;
                }

                btn.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                                confirmButtonText: 'OK'
                            }).then(() => window.location.href = '/login');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Unable to change password.'
                            });
                        }
                    },
                    error: function(xhr) {
                        let msg = 'An error occurred, please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON
                            .message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: msg
                        });
                    },
                    complete: function() {
                        btn.prop('disabled', false).text('Save Changes');
                    }
                });
            });

        });
    </script>
@endpush
