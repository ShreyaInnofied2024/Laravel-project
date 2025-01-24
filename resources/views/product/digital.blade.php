@include('inc.header') <!-- Assuming you have a main layout -->

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">View Digital Products</h1>
        <a href="{{ route('product_admin') }}" class="btn btn-outline-secondary">Go Back</a>
    </div>

    <!-- Product Details Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Category</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>Rs{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->category->name }}</td> <!-- Assuming you have a category relationship -->
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
