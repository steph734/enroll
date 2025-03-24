<!DOCTYPE html>
<html lang="en">

<head>
    @include('login.signupcss')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <div class="signup-container w-100 p-4 bg-white rounded shadow">
                    <h2 class="text-center mb-4">Sign Up</h2>
                    <form method="POST" action="{{ route('signup') }}">
                        @csrf
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">{{ __('Username') }}</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}" required autocomplete="username">
                            @if ($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                autocomplete="new-password">
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required autocomplete="new-password">
                            @if ($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-custom text-white w-100">{{ __('Register') }}</button>
                    </form>
                    <p class="text-center mt-3">
                        {{ __('Already registered?') }}
                        <a href="{{ route('login') }}">{{ __('Login here') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>