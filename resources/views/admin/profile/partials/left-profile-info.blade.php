<div class="col-12 col-md-12 col-lg-5">
    <div class="card profile-widget shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="profile-widget-header text-center py-4 bg-gradient-primary text-white position-relative">
            <img alt="avatar"
                 src="{{ $data->photo ? asset('uploads/admin_images/' . $data->photo) : asset('uploads/no_image.jpg') }}"
                 class="rounded-circle border border-white shadow-sm" width="120" id="profileAvatar">
            <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-success" title="Online"></span>
        </div>
        <div class="profile-widget-description text-center p-4">
            <h4 class="mb-1 fw-bold" id="profileName">{{ Auth::user()->name }}</h4>
            <p class="text-muted mb-1"><i class="fas fa-user-tie me-2"></i> Web Developer</p>
            <p class="text-muted mb-1"><i class="fas fa-envelope me-2"></i> <span id="profileEmail">{{ $data->email }}</span></p>
            <p class="text-muted mb-1"><i class="fas fa-phone me-2"></i> <span id="profilePhone">{{ $data->phone ?? '-' }}</span></p>
            <p class="text-muted mb-0"><i class="fas fa-link me-2"></i>
                <a href="{{ $data->link_social }}" target="_blank" id="profileSocial" class="text-decoration-none">
                    {{ $data->link_social ?? 'No social link' }}
                </a>
            </p>
        </div>
    </div>
</div>
