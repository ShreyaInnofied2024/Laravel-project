<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetic Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="index.js"></script>
    <script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>
</head>

<body>

    <header>
        @include('inc.header')
    </header>

    <section id="login" class="d-flex justify-content-center align-items-start py-5" style="min-height: 100vh;">
    <div class="login-container bg-white p-4 rounded shadow-sm w-100" style="max-width: 500px;">
        <h2 class="text-center mb-4" style="color: #a27053;">Add Category</h2>
        
        @if(auth()->user()->user_role === 'admin')
        <form id="category" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @elseif(auth()->user()->user_role === 'seller')
        <form id="category" action="{{ route('seller.category.store') }}" method="POST" enctype="multipart/form-data">
        @endif

            @csrf

            <div class="mb-3">
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Enter category name">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn" style="background-color: #a27053; color: white;">Submit</button>
        </form>

        <div class="mt-3 text-center">
            @if(auth()->user()->user_role === 'admin')
            <a href="{{ route('category.index') }}" class="text-decoration-none text-secondary">Go Back</a>
            @elseif(auth()->user()->user_role === 'seller')
            <a href="{{ route('seller.category.index') }}" class="text-decoration-none text-secondary">Go Back</a>
            @endif
        </div>
    </div>
</section>



</body>

</html>