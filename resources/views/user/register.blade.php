<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetic Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('index.js') }}"></script>
    <script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <!-- Include the header Blade template -->
        @include('inc.header')
    </header>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <section id="register">
        <div class="register-container">
            <h2>Create an Account</h2>
            <p>Join us and enjoy exclusive offers and products!</p>
            <form action="{{ route('register') }}" method="post">
                @csrf <!-- CSRF protection -->
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                 <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
             </div>
                <button type="submit" class="btn register-btn btn-block">Sign Up</button>
            </form>
            <div class="form-footer">
                <p>Already have an account? <a href="{{ route('login') }}">Log in</a></p>
            </div>
        </div>
    </section>
</body>
</html>
