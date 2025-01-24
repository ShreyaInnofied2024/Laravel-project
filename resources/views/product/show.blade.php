@include('inc.header')

<style>
    /* General Container Styling */
    .container {
        padding: 50px 15px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-family: 'Arial', sans-serif;
        color: #a27053;
        font-size: 36px;
        font-weight: bold;
    }

    .btn-outline-secondary {
        font-weight: 600;
        border-radius: 5px;
    }

    /* Flash Message Styling */
    .flash-message {
        font-size: 18px;
        padding: 15px;
        margin-top: 20px;
        background-color: #a27053;
        color: white;
        text-align: center;
        border-radius: 5px;
    }

    .flash-message.alert-danger {
        background-color: #e74c3c;
    }

    /* Carousel Styling */
    .carousel {
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .carousel-inner img {
        border-radius: 10px;
        max-height: 400px;
        /* Small Carousel Images */
        object-fit: cover;
        margin: auto;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: #a27053;
        border-radius: 50%;
        width: 30px;
        height: 30px;
    }

    /* Product Details Styling */
    .product-details {
        padding-left: 20px;
    }

    .product-details h4 {
        font-family: 'Arial', sans-serif;
        font-size: 24px;
        color: #333;
        font-weight: bold;
    }

    .product-details p {
        font-size: 16px;
        line-height: 1.6;
        color: #333;
        font-weight: bold;
    }

    .product-details p strong {
        color: #a27053;
    }

    .product-details .btn {
        background-color: #a27053;
        color: white;
        border-radius: 5px;
        font-weight: 600;
        padding: 10px 20px;
    }

    .product-details .btn:hover {
        background-color: #8c5e3c;
    }
</style>

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center page-header mb-4">
        <h1 class="text-uppercase">View Product</h1>
        <a href="{{ session('user_role') === 'Admin' ? route('products.index') : url('/') }}" class="btn btn-outline-secondary">Go Back</a>
    </div>



    <div class="row">
        <!-- Product Images Carousel -->
        <div class="col-md-5">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if (count($product->images) > 0)
                    @foreach ($product->images as $index => $image)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100 img-fluid img-custom" alt="Product Image">
                    </div>
                    @endforeach
                    @else
                    <div class="carousel-item active">
                        <img src="{{ asset('img/default-image.jpg') }}" class="d-block w-100 img-fluid img-custom" alt="No image available">
                    </div>
                    @endif

                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="col-md-7 product-details">
            <h4>{{ $product->name }}</h4>
            <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
            <p><strong>Price:</strong> Rs {{ number_format($product->price, 2) }}</p>
            <p><strong>Type:</strong> {{ ucfirst($product->type) }}</p>
            <p><strong>Category:</strong> {{ $product->category->name }}</p>
            @if (!session('user_role') || session('user_role') === 'Customer')
            <a href="" class="btn mt-3">Add to Cart</a>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
