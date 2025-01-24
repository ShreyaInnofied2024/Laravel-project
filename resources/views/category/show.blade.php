@include('inc.header')

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">{{ $category->name }}</h1>
        <a href="/category" class="btn btn-outline-secondary">Go Back</a>
    </div>

    <!-- Product Details Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody> @foreach($category->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->type }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>






