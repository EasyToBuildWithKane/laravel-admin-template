<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.auth.partials.head')
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand text-center">
                            <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100"
                                class="shadow-light rounded-circle">
                            <h4 class="mt-2">Admin Panel</h4>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="login">Username or Email</label>
                                        <input id="login" type="text" name="login" value="{{ old('login') }}"
                                            class="form-control @error('login') is-invalid @enderror"
                                            placeholder="Enter your username or email..." required autofocus>
                                        @error('login')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input id="password" type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter your password..." required>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block"
                                            id="login-btn">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="simple-footer text-center">&copy; KaneNguyen {{ now()->year }}</div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>
@include('admin.auth.partials.foot')

</html>
