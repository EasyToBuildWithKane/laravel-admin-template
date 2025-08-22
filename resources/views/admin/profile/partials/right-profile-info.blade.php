<div class="col-md-7">
    <div class="card shadow-sm border-0 rounded-4">
        <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data" id="profileForm">
            @csrf
            <div class="card-header bg-light">
                <h4 class="mb-0">Edit Profile</h4>
            </div>
            <div class="card-body">

                <div class="row g-3">
                    {{-- Username --}}
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Enter a unique username">
                            <i class="fas fa-user me-1"></i> Username
                        </label>
                        <input type="text" name="name" required
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $data->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- First Name --}}
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Your first name">
                            <i class="fas fa-id-badge me-1"></i> First Name
                        </label>
                        <input type="text" name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ old('first_name', $data->first_name) }}">
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Your last name">
                            <i class="fas fa-id-card me-1"></i> Last Name
                        </label>
                        <input type="text" name="last_name"
                            class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ old('last_name', $data->last_name) }}">
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip"
                            title="Enter a valid Vietnamese phone number">
                            <i class="fas fa-phone me-1"></i> Phone
                        </label>
                        <input type="tel" name="phone" placeholder="Enter phone..."
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $data->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Social Link --}}
                    <div class="col-12">
                        <label class="form-label" data-bs-toggle="tooltip"
                            title="Enter your Facebook/LinkedIn/Website URL">
                            <i class="fas fa-link me-1"></i> Social Link
                        </label>
                        <input type="url" name="link_social"
                            class="form-control @error('link_social') is-invalid @enderror"
                            placeholder="https://facebook.com/username"
                            value="{{ old('link_social', $data->link_social) }}">
                        @error('link_social')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Avatar --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Avatar</label>
                        <div class="border rounded-3 p-3 text-center position-relative"
                            style="border-style: dashed; cursor: pointer;"
                            onclick="document.getElementById('image').click()">
                            <img id="previewAvatar"
                                src="{{ $data->photo ? asset('uploads/admin_images/' . $data->photo) : asset('uploads/no_image.jpg') }}"
                                class="rounded-circle shadow-sm mb-2" width="120" height="120"
                                style="object-fit: cover;">
                            <p class="mb-1 small text-muted">Click or drag & drop to change</p>
                            <input type="file" name="photo" id="image" accept="image/*" class="d-none">
                        </div>
                        @if ($data->photo)
                            <button type="button" id="removeImageBtn" class="btn btn-outline-danger btn-sm mt-2">
                                <i class="fas fa-trash-alt me-1"></i> Remove current avatar
                            </button>
                        @endif

                        <p class="text-muted small mt-2" id="noAvatarHint"
                            style="{{ $data->photo ? 'display: none;' : '' }}">
                            You haven't uploaded any avatar yet.
                        </p>
                        <input type="hidden" name="remove_current_photo" id="removeCurrentPhoto" value="0">

                    </div>
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    <span class="btn-text">Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
