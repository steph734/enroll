<!DOCTYPE html>
<html lang="en">

<head>
    @include('login.logincss')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="login-container w-100 p-4 bg-white rounded shadow">
                    <h2 class="text-center mb-4">Login</h2>

                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">{{ __('Username') }}</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}" required autofocus autocomplete="username">
                            @if ($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                autocomplete="current-password">
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-custom text-white w-100">{{ __('Login') }}</button>
                    </form>
                    <p class="text-center mt-3">
                        {{ __('Don\'t have an account?') }}
                        <a href="{{ route('signup') }}">{{ __('Sign Up here') }}</a>
                    </p>
                </div>
            </div>
            <div class="col-6">
                <p>Effortless enrollment, seamless access.</p>
                <img src="{{ asset('img/logo1.png') }}" alt="Logo" width="500" height="500">
            </div>
        </div>
    </div>
</body>

</html>