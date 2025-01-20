@include('inc.header')

@include('inc/banner')

<!-- Featured Offers Section -->
<section id= offer style=" margin-top: 20px">
<div id="offers" class="container mb-5">
    <h2 class="text-center mb-4">Featured Offers</h2>
    <div class="row">
        <!-- First Offer -->
        <div class="col-md-4 mb-4">
            <div class="card offer-card bg-light text-center">
                <div class="card-body">
                    <h5 class="card-title">Buy One, Get One Free</h5>
                    <p class="card-text">On selected lipsticks. Limited time offer!</p>
                </div>
            </div>
        </div>
        
        <!-- Second Offer -->
        <div class="col-md-4 mb-4">
            <div class="card offer-card bg-light text-center">
                <div class="card-body">
                    <h5 class="card-title">20% Off Skincare</h5>
                    <p class="card-text">All skincare products for this month only.</p>
                     </div>
            </div>
        </div>
        
        <!-- Third Offer -->
        <div class="col-md-4 mb-4">
            <div class="card offer-card bg-light text-center">
                <div class="card-body">
                    <h5 class="card-title">Free Shipping</h5>
                    <p class="card-text"> On selected items. order above $50! </p>
                     </div>
            </div>
        </div>
    </div>
</div>
</section>


<!-- New Arrivals Carousel -->
 <section>
<div id="arrivals" class="container-fluid p-0 mb-5">
    <h2 class="text-center mb-4">New Arrivals</h2>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/sunscreen.png') }}" class="d-block mx-auto carousel-image" alt="Sunscreen">
                <div class="carousel-caption d-block d-md-block">
                    <h5 class="carousel-heading">Sunscreen</h5>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/Lipstick.png') }}" class="d-block mx-auto carousel-image" alt="Lipstick">
                <div class="carousel-caption d-block d-md-block">
                    <h5 class="carousel-heading">Lipstick</h5>
                </div>                
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/perfume.png') }}" class="d-block mx-auto carousel-image" alt="Perfume">
                <div class="carousel-caption d-block d-md-block">
                    <h5 class="carousel-heading">Perfume</h5>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
 </section>
 

 <section id="filters" class="container mt-5">
 <h2 class="text-center mb-4">Our Products</h2>
    <form method="GET" action="{{ route('home') }}">
        <div class="row gy-3 align-items-center">
            <!-- Category Filter -->
            <div class="col-md-4">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Price Range Filters -->
            <div class="col-md-3">
                <label for="min_price" class="form-label">Min Price</label>
                <input type="number" id="min_price" name="min_price" 
                       class="form-control" placeholder="e.g., 100" 
                       value="{{ request('min_price') }}">
            </div>
            <div class="col-md-3">
                <label for="max_price" class="form-label">Max Price</label>
                <input type="number" id="max_price" name="max_price" 
                       class="form-control" placeholder="e.g., 1000" 
                       value="{{ request('max_price') }}">
            </div>

            <!-- Buttons -->
            <div class="col-md-2 d-flex justify-content-between align-items-end">
                <button type="submit" class="btn btn-primary w-100 me-2">Filter</button>
                <a href="{{ route('home') }}" class="btn btn-secondary w-100">Clear</a>
            </div>
        </div>
    </form>
</section>

<!-- Paginated Products Section -->
<section id="products" class="container mt-5">
   
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm border-0 h-100">
                    <img src="{{ asset('images/' . $product->image) }}" 
                         class="card-img-top img-fluid p-3 rounded" 
                         alt="{{ $product->name }}" 
                         style="height: 200px; object-fit: cover;">

                    <div class="card-body d-flex flex-column text-center">
                        <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                        <p class="text-muted mb-3">Rs {{ number_format($product->price, 2) }}</p>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Add to Cart</button>
</form>

                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</section>



@include('inc.footer')
