@push('scripts')
    <script>
        $(function() {
            const defaultAvatar = '{{ asset('uploads/no_image.jpg') }}';

            // -------------------
            // Elements
            // -------------------
            const $form = $('#profileForm');
            const $btn = $form.find('button[type=submit]');
            const $spinner = $btn.find('.spinner-border');
            const $btnText = $btn.find('.btn-text');
            const $dz = $('#avatarDropzone');
            const $file = $('#image');
            const $previewForm = $('#showImage');
            const $profileAvatar = $('#profileAvatar');
            const $removeBtn = $('#removeImageBtn');
            const $nameInput = $('#nameInput');
            const $phoneInput = $('#phoneInput');
            const $socialInput = $('#linkSocialInput');

            // -------------------
            // Helpers
            // -------------------
            const showAlert = (icon, title, text, timer = null) => {
                Swal.fire({
                    icon,
                    title,
                    html: text, // Cho phép HTML xuống dòng
                    timer,
                    showConfirmButton: !timer
                });
            };

            const setButtonLoading = (state) => {
                $btn.prop('disabled', state);
                $spinner.toggleClass('d-none', !state);
                $btnText.text(state ? 'Saving...' : 'Save Changes');
            };

            const applyWidgetData = (data) => {
                if (!data) return;
                $profileAvatar.attr('src', data.photo_url || defaultAvatar);
                $('#profileName').text(data.name);
                $('#profilePhone').text(data.phone || '-');
                if (data.link_social) {
                    $('#profileSocial').text(data.link_social).attr('href', data.link_social);
                } else {
                    $('#profileSocial').text('No social link').removeAttr('href');
                }
            };

            const clearValidation = () => {
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();
            };

            // -------------------
            // Avatar Preview
            // -------------------
            function handleFile(file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
                const maxBytes = 2 * 1024 * 1024; // 2 MB

                if (!validTypes.includes(file.type)) {
                    showAlert('error', 'Invalid file', 'Please upload JPG/PNG/WEBP/GIF only.');
                    $file.val('');
                    return;
                }
                if (file.size > maxBytes) {
                    showAlert('error', 'File too large', 'Max allowed: 2MB.');
                    $file.val('');
                    return;
                }

                const url = URL.createObjectURL(file);
                $previewForm.attr('src', url);
                $profileAvatar.attr('src', url);
                $('#removeCurrentPhoto').val('0');
                $removeBtn.removeClass('d-none').show();
            }

            // -------------------
            // Drag & Drop
            // -------------------
            const highlight = () => $dz.addClass('border-primary');
            const unhighlight = () => $dz.removeClass('border-primary');

            $dz.on('click', () => $file.trigger('click'));
            $dz.on('dragenter dragover', (e) => {
                e.preventDefault();
                highlight();
            });
            $dz.on('dragleave dragend drop', (e) => {
                e.preventDefault();
                unhighlight();
            });

            $dz.on('drop', function(e) {
                const dt = e.originalEvent.dataTransfer;
                if (dt?.files?.length) {
                    $file.prop('files', dt.files);
                    handleFile(dt.files[0]);
                }
            });

            $file.on('change', function() {
                if (this.files?.[0]) handleFile(this.files[0]);
            });

            // -------------------
            // Remove Avatar
            // -------------------
            $removeBtn.on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will permanently remove your avatar!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove!',
                    cancelButtonText: 'Cancel'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    $.post('{{ route('admin.profile.remove-photo') }}', {
                        _token: '{{ csrf_token() }}'
                    }).done(res => {
                        if (res.status === 'success') {
                            const src = res.photo || defaultAvatar;
                            $previewForm.attr('src', src);
                            $profileAvatar.attr('src', src);
                            $('#previewAvatar').attr('src', src); 
                            $('#removeCurrentPhoto').val('1');
                            $removeBtn.hide();
                            showAlert('success', 'Removed!', res.message);
                        } else {
                            showAlert('error', 'Error!', res.message);
                        }
                    }).fail(xhr => {
                        showAlert('error', 'Error!', xhr.responseJSON?.message ||
                            'Failed to remove avatar.');
                    });
                });
            });

            // -------------------
            // Live Preview Inputs
            // -------------------
            $nameInput.on('input', () => $('#profileName').text($nameInput.val()));

            $phoneInput.on('input', function() {
                let val = this.value.replace(/\D/g, '').slice(0, 10);
                if (val.length === 1 && val !== '0') val = '0';
                this.value = val;
                $('#profilePhone').text(val || '-');
            });

            $socialInput.on('input', function() {
                const val = $(this).val().trim();
                const $socialPreview = $('#socialPreview');
                if (val) $socialPreview.text(val).attr('href', val);
                else $socialPreview.text('No social link').removeAttr('href');
            });

            // -------------------
            // Form Submit (AJAX)
            // -------------------
            $form.on('submit', function(e) {
                e.preventDefault();
                clearValidation();
                setButtonLoading(true);

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                }).done(res => {
                    if (res.status === 'success') {
                        applyWidgetData(res.data);
                        showAlert('success', 'Success!', res.message);
                    } else {
                        showAlert('error', 'Error!', res.message || 'Update failed.');
                    }
                }).fail(xhr => {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        const errs = xhr.responseJSON.errors;
                        let list = [];
                        for (const field in errs) {
                            const $input = $form.find(`[name="${field}"]`);
                            $input.addClass('is-invalid')
                                .after(
                                    `<div class="invalid-feedback d-block">${errs[field][0]}</div>`
                                );
                            list.push(errs[field][0]);
                        }
                        showAlert('error', 'Validation Error', list.join('<br>'));
                    } else {
                        showAlert('error', 'Error!', xhr.responseJSON?.message || 'Update failed.');
                    }
                }).always(() => {
                    setButtonLoading(false);
                });
            });

            // -------------------
            // Flash Messages
            // -------------------
            @if (session('success'))
                showAlert('success', 'Success!', @json(session('success')), 2000);
            @endif

            @if (session('error'))
                showAlert('error', 'Error!', @json(session('error')));
            @endif
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('image');
            const preview = document.getElementById('previewAvatar');
            const dropArea = preview.closest('.border'); // vùng drag/drop

            // Khi chọn file
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Hỗ trợ drag & drop
            dropArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-primary');
            });
            dropArea.addEventListener('dragleave', function(e) {
                this.classList.remove('border-primary');
            });
            dropArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-primary');
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                    fileInput.files = e.dataTransfer.files; // gán vào input
                }
            });
        });
    </script>
@endpush
