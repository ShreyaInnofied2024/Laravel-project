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

@include('inc.footer')
