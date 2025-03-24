<!DOCTYPE html>
<html lang="en">

<head>
    @include ('login.logincss')
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6 ">
                <div class="login-container w-100 p-4  bg-white rounded shadow">
                    <h2 class="text-center mb-4">Login</h2>
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($error) ?>
                    </div>
                    <?php endif; ?>
                    <form method="POST" action="{{ route('signup') }}">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-custom text-white w-100">Login</button>
                    </form>
                    <p class="text-center mt-3">Don't have an account? <a href="{{ route('signup') }}">Sign Up
                            here</a>
                    </p>
                </div>
            </div>
            <div class="col-6">
                <p>Effortless enrollment, seamless access.</p>
                <img src="img/logo1.png" alt="" width="500" height="500">
            </div>
        </div>
    </div>
</body>

</html>