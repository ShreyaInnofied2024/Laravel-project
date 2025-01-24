<!-- views/inc/navbar.php -->
<style>
    /* Position the badge above the cart link */
.badge-cart {
    position: absolute;
    top: -5px; 
    right: -10px; 
    background-color: #343a40; /* Dark color */
    color: white;
}

.position-relative{
    margin-right: 10px;
}
</style>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Cosmetic Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (Auth::check())
                @if (Auth::user()->user_role !== 'admin')
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('change-password-form', auth()->user()->email) }}">Change Password</a>
                </li>
                <!-- Inside your Blade view -->
                <li class="nav-item position-relative">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        Cart
                        <span class="badge badge-pill badge-cart">
                        {{ $cartCount ?? '0' }}
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.history')}}">Order History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout">Logout</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                @endif
                @endif

                @if (Auth::check())
                @if (Auth::user()->user_role == 'admin')
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('admin.dashboard')}}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('product_admin') }}">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/category">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/orders">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout">Logout</a>
                </li>

                @endif
                @endif

                @if (!Auth::check())
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                @endif
                
            </ul>
        </div>
    </nav>
</header>