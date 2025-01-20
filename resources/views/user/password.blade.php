<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header>
    @include('inc.header')
</header>

<section id="login">
    <div class="login-container">
        <h2>Change Password</h2>
        <p>Update your account password.</p>
        <form action="{{ route('change-password', $email) }}" method="post">
            @csrf
            <div class="form-group">
                <input type="email" name="email" id="email"
                       class="form-control rounded-pill @error('email') is-invalid @enderror"
                       value="{{ old('email', $email) }}" placeholder="Enter your email" required>
                @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password"
                       class="form-control rounded-pill @error('password') is-invalid @enderror"
                       placeholder="Enter your new password" required>
                @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control rounded-pill" placeholder="Confirm your new password" required>
            </div>
            <button type="submit" class="btn login-btn btn-block">Submit</button>
        </form>
        <div class="form-footer">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #a27053;">Login</a> | 
            <a href="{{ url('/') }}" class="text-decoration-none" style="color: #a27053;">Go Back</a>
        </div>
    </div>
</section>
</body>
</html>
