{{-- ==========================
     Page-specific JS
=========================== --}}
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Logout Successful',
                text: @json(session('success')),
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        const loginBtn = document.getElementById('login-btn');
        const originalText = loginBtn?.textContent || 'Submit';

        const showAlert = (icon, title, text, timer = null) => {
            Swal.fire({
                icon,
                title,
                text,
                timer,
                showConfirmButton: timer ? false : true
            });
        };

        // ---------- Client-side Validation ----------
        form?.addEventListener('submit', e => {
            const login = document.getElementById('login')?.value.trim();
            const password = document.getElementById('password')?.value.trim();

            if (!login || !password) {
                e.preventDefault();
                const msg = !login && !password ?
                    'Please enter both username and password.' :
                    !login ? 'Please enter your username.' : 'Please enter your password.';
                showAlert('warning', 'Missing Information', msg);
                return;
            }

            loginBtn.disabled = true;
            loginBtn.textContent = 'Logging in...';
        });

        // ---------- Session Messages ----------
        @if (session('error'))
            showAlert('error', 'Login Failed', @json(session('error')));
            loginBtn.disabled = false;
            loginBtn.textContent = originalText;
        @endif

        @if (session('message'))
            showAlert('success', 'Success', @json(session('message')), 2000);
        @endif

        // ---------- Throttle / Countdown ----------
        @if ($errors->has('throttle'))
            let countdown = {{ $errors->first('throttle') }};
            loginBtn.disabled = true;

            Swal.fire({
                icon: 'error',
                title: 'Too Many Login Attempts',
                html: `You have entered incorrect credentials too many times.<br>
                   Please try again in <b id="swal-countdown">${countdown}</b> seconds.`,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    const interval = setInterval(() => {
                        countdown--;
                        document.getElementById('swal-countdown').textContent = countdown;
                        loginBtn.textContent =
                        `Please try again in ${countdown} seconds...`;

                        if (countdown <= 0) {
                            clearInterval(interval);
                            loginBtn.disabled = false;
                            loginBtn.textContent = originalText;
                            Swal.close();
                        }
                    }, 1000);
                }
            });
        @endif
    });
</script>
