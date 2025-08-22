<!-- Check Session for Multi-Device Login -->
<script type="text/javascript">
    setInterval(() => {
        fetch("{{ route('check.session') }}")
            .then(res => res.json())
            .then(data => {
                if (data.logout) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please Log In Again!',
                        text: 'Your account has been logged in on another device.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('login') }}";
                    });
                }
            })
            .catch(err => console.error(err));
    }, 10000); // check every 10 seconds
</script>

<!-- Display Session Messages via SweetAlert -->
@if(session('message'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('message')),
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
            confirmButtonText: 'OK'
        });
    });
</script>
@endif
