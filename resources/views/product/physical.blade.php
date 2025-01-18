@include('inc.header')
<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">View Physical Products</h1>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Go Back</a>
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
                    <th>Image</th> <!-- New column for images -->
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>Rs {{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            @if (!empty($product->image_path))
                                <img src="{{ asset($product->image_path) }}" alt="Product Image" style="width: 100px; height: auto;">
                            @else
                                <span>No image available</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
